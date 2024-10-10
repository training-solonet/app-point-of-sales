<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Pembelian;
use App\Models\Stok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StokBarangController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $stok = Stok::select('barang_id', DB::raw('SUM(harga_beli) as total_harga_beli'))
                ->with(['barang'])
                ->whereNull('jual_id')
                ->groupBy('barang_id')
                ->get();

            return datatables()->of($stok)
                ->addIndexColumn()
                ->addColumn('barang_id', function ($row) {
                    return $row->barang->nama;
                })
                ->addColumn('stok', function ($row) {
                    $jml_stok = Stok::where('barang_id', $row->barang_id)
                        ->whereNull('jual_id')
                        ->count();

                    return $jml_stok;
                })
                ->addColumn('nominal', function ($row) {
                    return $row->total_harga_beli;
                })
                ->addColumn('action', function ($data) {
                    $button = '<a href="/report/stok-barang/'.$data->barang_id.'" class="btn btn-info waves-effect waves-light">Detail</a>';

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
            $stok = Stok::where('barang_id', $id)
                ->whereNull('jual_id')
                ->with(['pembelian.purchase_orders.distributor'])
                ->get();

            return datatables()->of($stok)
                ->addIndexColumn()
                ->addColumn('tanggal_masuk', function ($row) {
                    return $row->tanggal_masuk;
                })
                ->addColumn('harga_beli', function ($row) {
                    return $row->harga_beli;
                })
                ->make(true);
        }

        $barang = Barang::find($id);

        if (! $barang) {
            abort(404);
        }

        $barangName = $barang->nama;

        $pembelian = Pembelian::all();

        return view('report.stok-barang.detail', compact('barangName', 'id'));

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
