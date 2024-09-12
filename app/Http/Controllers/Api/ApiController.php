<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Customer;
use App\Models\DetJual;
use App\Models\Jual;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
    public function product(Request $request)
    {
        $kategoriId = $request->get('kategori');
        $barcode = $request->get('upc');

        $stokData = DB::table('stok')
            ->select('barang_id', DB::raw('COUNT(barang_id) as total_stok'))
            ->groupBy('barang_id');

        $query = Barang::with('kategori')
            ->joinSub($stokData, 'stok_data', function ($join) {
                $join->on('barang.id', '=', 'stok_data.barang_id');
            });

        if ($kategoriId) {
            $query->where('id_kategori', $kategoriId);
        }

        if ($barcode) {
            $query->where('upc', $barcode);
        }

        $data = $query->select('barang.id', 'barang.nama', 'barang.harga_jual', 'stok_data.total_stok as stok', 'barang.id_kategori', 'barang.gambar')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'nama' => $item->nama,
                    'kategori' => $item->kategori->nama,
                    'gambar' => $item->gambar,
                    'harga' => $item->harga_jual,
                    'stok' => $item->stok,
                ];
            });

        return response()->json([
            'status' => 'success',
            'message' => 'Data barang berhasil diambil',
            'data' => $data,
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
        $salesData = DB::table('det_jual')
            ->select('barang_id', DB::raw('COUNT(barang_id) as total_sold'))
            ->groupBy('barang_id');

        $query = Barang::with('kategori')
            ->joinSub($salesData, 'sales_data', function ($join) {
                $join->on('barang.id', '=', 'sales_data.barang_id');
            });

        $data = $query->select('barang.id', 'barang.nama', 'barang.harga_jual', 'sales_data.total_sold as total_sold', 'barang.id_kategori', 'barang.gambar')
            ->orderBy('total_sold', 'desc')
            ->limit(10)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'nama' => $item->nama,
                    'kategori' => $item->kategori->nama,
                    'gambar' => $item->gambar,
                    'harga' => $item->harga_jual,
                    'total_sold' => $item->total_sold,
                ];
            });

        return response()->json([
            'status' => 'success',
            'message' => 'Best seller products berhasil diambil',
            'data' => $data,
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
        ]);

        $customer = Customer::where('nama', $request->customer_name)->first();

        if (! $customer) {
            return response()->json([
                'status' => 'error',
                'message' => 'Customer tidak ditemukan',
            ], 404);
        }

        // Jual Record
        $jual = new Jual;
        $jual->no_faktur = 'INV-'.time();
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
            $harga_jual = $barang->harga_jual + 4000;

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
            'message' => 'Order placed successfully',
            'data' => [
                'jual' => $jual,
                'details' => $jual->detJual()->get(),
            ],
        ], 200);
    }
}
