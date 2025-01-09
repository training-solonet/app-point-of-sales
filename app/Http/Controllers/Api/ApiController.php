<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Customer;
use App\Models\DetJual;
use App\Models\Jual;
use App\Models\Kategori;
use App\Models\Stok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
    public function product(Request $request)
    {
        $kategoriId = $request->get('kategori');
        $barcode = $request->get('upc');

        $stokData = Stok::with([
                    'barang' => function ($query) use ($kategoriId, $barcode) {
                        $query->select('id', 'nama', 'harga_jual', 'id_kategori', 'gambar', 'upc')
                        ->when($kategoriId, function ($query) use ($kategoriId) {
                            return $query->where('id_kategori', $kategoriId);
                        })
                        ->when($barcode, function ($query) use ($barcode) {
                            return $query->where('upc', $barcode);
                        });
                    },
                    'barang.kategori',
            ])
            ->whereHas('barang', function ($query) use ($kategoriId, $barcode) {
                $query->when($kategoriId, function ($query) use ($kategoriId) {
                    return $query->where('id_kategori', $kategoriId);
                })
                ->when($barcode, function ($query) use ($barcode) {
                    return $query->where('upc', $barcode);
                });
            })
            ->select('barang_id', DB::raw('COUNT(barang_id) as total_stok'))
            ->whereNull('tanggal_keluar')
            ->groupBy('barang_id')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->barang->id,
                    'nama' => $item->barang->nama,
                    'kategori' => $item->barang->kategori->nama,
                    'gambar' => $item->barang->gambar,
                    'harga' => $item->barang->harga_jual,
                    'stok' => $item->total_stok,
                    'upc' => $item->barang->upc,
                ];
            });

        return response()->json([
            'status' => 'success',
            'message' => 'Data barang berhasil diambil',
            'data' => $stokData,
        ], 200);
    }

    public function category()
    {
        $data = Kategori::select('id', 'nama')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'nama' => $item->nama,
                ];
            });

        return response()->json([
            'status' => 'success',
            'message' => 'Data kategori berhasil diambil',
            'data' => $data,
        ]);
    }

    public function customer()
    {
        $customerNama = request()->get('nama');
        $customerNo = request()->get('no_hp');

        $data = Customer::select('id', 'nama', 'no_hp')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'nama' => $item->nama,
                    'no_hp' => $item->no_hp,
                ];
            });

        if ($customerNama) {
            $data = Customer::select('id', 'nama', 'no_hp')
                ->where('nama', 'like', "%$customerNama%")
                ->get()
                ->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'nama' => $item->nama,
                        'no_hp' => $item->no_hp,
                    ];
                });
        }

        if ($customerNo) {
            $data = Customer::select('id', 'nama', 'no_hp')
                ->where('no_hp', 'like', "%$customerNo%")
                ->get()
                ->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'nama' => $item->nama,
                        'no_hp' => $item->no_hp,
                    ];
                });
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Data customer berhasil diambil',
            'data' => $data,
        ]);
    }

    public function bestSeller()
    {
        $salesData = DetJual::select('barang_id', DB::raw('COUNT(barang_id) as total_sold'))
            ->groupBy('barang_id')
            ->orderBy('total_sold', 'desc')
            ->limit(10)
            ->pluck('barang_id')
            ->toArray();

        $stokData = Stok::with([
                'barang' => function ($query)  {
                    $query->select('id', 'nama', 'harga_jual', 'id_kategori', 'gambar', 'upc');
                },
                'barang.kategori',
        ])
        ->select('barang_id', DB::raw('COUNT(barang_id) as total_stok'))
        ->whereNull('tanggal_keluar')
        ->whereIn('barang_id', $salesData)
        ->groupBy('barang_id')
        ->get()
        ->map(function ($item) {
            return [
                'id' => $item->barang->id,
                'nama' => $item->barang->nama,
                'kategori' => $item->barang->kategori->nama,
                'gambar' => $item->barang->gambar,
                'harga' => $item->barang->harga_jual,
                'stok' => $item->total_stok,
                'upc' => $item->barang->upc,
            ];
        });

        return response()->json([
            'status' => 'success',
            'message' => 'Best seller products berhasil diambil',
            'data' => $stokData,
        ], 200);
    }

    public function order(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string',
            'products' => 'required|array',
            'products.*.barang_id' => 'required|integer|exists:barang,id',
            'products.*.qty' => 'required|integer|min:1',
            'payment_method' => 'required|string|in:cash,bank,piutang',
            'alamat' => 'nullable|string',
            'no_hp' => 'nullable|string',
        ]);

        $customer = Customer::where('nama', $request->customer_name)->first();
        if (! $customer) {
            $customer = new Customer;
            $customer->nama = $request->customer_name;
            $customer->no_hp = $request->input('no_hp') ?? null;
            $customer->alamat = $request->input('alamat') ?? null;
            $customer->save();
        }

        $jual = new Jual;
        $jual->no_faktur = 'INV-'.now();
        $jual->customer_id = $customer->id;
        $jual->tanggal = now();
        $jual->diskon = 0;
        $jual->status = $request->input('payment_method');
        $jual->total = 0;
        $jual->bayar = 0;
        $jual->ppn = 0;
        $jual->save();

        $total = 0;

        foreach ($request->input('products') as $product) {
            $barang = Barang::find($product['barang_id']);
            $harga_jual = $barang->harga_jual;

            $availableStock = DB::table('stok')
                ->where('barang_id', $product['barang_id'])
                ->whereNull('jual_id')
                ->orderBy('tanggal_masuk', 'asc')
                ->limit($product['qty'])
                ->get();

            if ($availableStock->count() < $product['qty']) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Not enough stock for product: '.$barang->nama,
                ], 400);
            }

            DB::table('stok')
                ->whereIn('id', $availableStock->pluck('id')->toArray())
                ->update([
                    'jual_id' => $jual->id,
                    'harga_jual' => $harga_jual,
                    'tanggal_keluar' => now(),
                ]);

            $detJual = new DetJual;
            $detJual->jual_id = $jual->id;
            $detJual->barang_id = $product['barang_id'];
            $detJual->qty = $product['qty'];
            $detJual->harga_jual = $harga_jual;
            $detJual->diskon = 0;
            $detJual->harga_beli = $barang->harga_jual;
            $detJual->save();

            $total += $harga_jual * $product['qty'];
        }

        $jual->total = $total;
        $jual->bayar = $total;
        $jual->ppn = $total * 0.11;
        $jual->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Order placed successfully and stock updated',
            'data' => [
                'jual' => $jual,
                'details' => $jual->detJual()->get(),
            ],
        ], 200);
    }
}
