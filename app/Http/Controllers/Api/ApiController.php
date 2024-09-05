<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Customer;
use App\Models\Kategori;

class ApiController extends Controller
{
    public function barang()
    {
        $data = Barang::select('id', 'nama', 'stok')
            ->where('stok', '>', 0)
            ->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Data barang berhasil diambil',
            'data' => $data,
        ]);
    }

    public function kategori()
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
        $data = Customer::select('id', 'nama', 'no_hp')->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Data customer berhasil diambil',
            'data' => $data,
        ]);
    }
}
