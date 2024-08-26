<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use App\Models\Stok;

class StokBarangController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $stok = Stok::with(['barang', 'detailPurchaseOrder'])->get();
    
            return datatables()->of($stok)
                ->addIndexColumn()
                ->addColumn('nama', function ($row) {
                    return $row->barang->nama;
                })
                ->addColumn('qty', function ($row) {
                    return $row->detailPurchaseOrder->qty?? '-';
                })
                ->addColumn('action', function ($data) {
                    $button = '<a href="javascript:void(0)" id="btn-det-stok" data-id="' . $data->id . '" class="btn btn-info waves-effect waves-light">Detail</a>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    
        $barang = Barang::all();
        return view('report.stok-barang.index', compact('barang'));
    }
    




    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }


    public function show(string $id)
    {
        //
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
