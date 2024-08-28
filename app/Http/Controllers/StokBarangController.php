<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Stok;
use App\Models\Barang;
use App\Models\Pembelian;
use App\Models\DetailPembelian;

class StokBarangController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $stok = Stok::with(['barang', 'pembelian'])->get();

            return datatables()->of($stok)
                ->addIndexColumn()
                ->addColumn('barang_id', function ($row) {
                    return $row->barang->nama;
                })
                ->addColumn('pembelian_id', function ($row) {
                    return $row->pembelian->no_invoice;
                })
                ->addColumn('action', function ($data) {
                    $button = '<a href="/report/stok-barang/' . $data->id . '" class="btn btn-info waves-effect waves-light">Detail</button>';
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
            $stok = Stok::with(['detail_pembelian.barang'])
                ->where('id', $id)
                ->first();

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
