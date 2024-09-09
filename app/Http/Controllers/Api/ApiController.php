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

        $stokData = DB::table('stok')
            ->select('barang_id', DB::raw('COUNT(barang_id) as total_stok'))
            ->groupBy('barang_id');

        $query = Barang::with('kategori')
            ->joinSub($stokData, 'stok_data', function ($join) {
                $join->on('barang.id', '=', 'stok_data.barang_id');
            });

        if ($kategoriNama) {
            $query->whereHas('kategori', function ($q) use ($kategoriNama) {
                $q->where('nama', $kategoriNama);
            });
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
                ];
            });

        return response()->json([
            'status' => 'success',
            'message' => 'Best seller products berhasil diambil',
            'data' => $data,
        ], 200);
    }
}
