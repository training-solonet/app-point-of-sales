<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Stok;
use App\Models\Barang;
use App\Models\Purchase_order;
use App\Models\Distributor;
use Illuminate\Support\Facades\DB;


class StokBarangController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $stok = Stok::select('barang_id', DB::raw('SUM(harga_beli) as total_harga_beli'))
                ->with(['barang'])
                ->groupBy('barang_id')
                ->get();

            return datatables()->of($stok)
                ->addIndexColumn()
                ->addColumn('barang_id', function ($row) {
                    return $row->barang->nama;
                })
                ->addColumn('stok', function ($row) {
                    $jml_stok = Stok::where('barang_id', $row->barang_id)->count();
                    return $jml_stok;
                })
                ->addColumn('nominal', function ($row) {
                    return $row->total_harga_beli;
                })
                ->addColumn('action', function ($data) {
                    $button = '<a href="/report/stok-barang/' . $data->barang_id . '" class="btn btn-info waves-effect waves-light">Detail</a>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('report.stok-barang.index');
    }


    public function show(string $id, Request $request)
    {
        if ($request->ajax()) {
            $stok = Stok::with(['barang', 'purchase_orders.distributor'])
                ->where('id', $id)
                ->first();

            if ($stok->isEmpty()) {
                return response()->json(['error' => 'data not found'], 404);
            }

            $data = $stok->map(function ($detail) {
                return [
        //           'index' => $index + 1,
                    'tanggal_masuk' => $detail->tanggal_masuk,
                    'harga_beli' => $detail->harga_beli,
                    'distributor' => $detail->purchase_orders->distributor->name
                ];
            });

            return datatables()->of($data)
                ->addIndexColumn()
                ->make(true);
        }

        return view('report.stok-barang.detail', compact('id'));
    }


    public function edit(string $id)
    {
        //
    }


    public function update(Request $request, string $id)
    {
        //
    }


    public function destroy(string $id)
    {
        //
    }

}
