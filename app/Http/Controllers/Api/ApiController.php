<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Customer;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
    public function product(Request $request)
    {
        $kategoriNama = $request->get('kategori');
        $barcode = $request->get('upc');

        $query = Barang::with('kategori')->where('stok', '>', 0);

        if ($kategoriNama) {
            $query->whereHas('kategori', function ($q) use ($kategoriNama) {
                $q->where('nama', $kategoriNama);
            });
        }

        if ($barcode) {
            $query->where('upc', $barcode);
        }

        $data = $query->select('id', 'nama', 'harga_jual', 'stok', 'id_kategori', 'gambar')
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
        $data = Kategori::select('id', 'nama')->get();

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

        $data = Customer::select('id', 'nama', 'no_hp')->get();

        if ($customerNama) {
            $data = Customer::select('id', 'nama', 'no_hp')
                ->where('nama', 'like', "%$customerNama%")
                ->get();
        }

        if ($customerNo) {
            $data = Customer::select('id', 'nama', 'no_hp')
                ->where('no_hp', 'like', "%$customerNo%")
                ->get();
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Data customer berhasil diambil',
            'data' => $data,
        ]);
    }

    public function bestSeller()
    {
        $bestSellers = DB::table('det_jual')
            ->select('barang_id', DB::raw('SUM(qty) as total_qty'))
            ->groupBy('barang_id')
            ->orderBy('total_qty', 'desc')
            ->limit(10)
            ->get();

        $data = Barang::whereIn('id', $bestSellers->pluck('barang_id'))
            ->select('id', 'nama', 'harga_jual', 'stok', 'id_kategori', 'gambar')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'nama' => $item->nama,
                    'kategori' => $item->kategori->nama ?? 'N/A',
                    'gambar' => $item->gambar,
                    'harga' => $item->harga_jual,
                    'stok' => $item->stok,
                ];
            });

        return response()->json([
            'status' => 'success',
            'message' => 'Data best seller berhasil diambil',
            'data' => $data,
        ]);
    }
}
