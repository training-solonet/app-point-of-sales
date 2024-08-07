<?php

namespace App\Http\Controllers;

use App\Models\Jual;
use Illuminate\Http\Request;

class JurnalPiutangController extends Controller
{
    public function index(Request $request)
    {
        $piutang = Jual::with('customer')->where('status', 'piutang')->get();
        if ($request->ajax()) {
            return datatables()->of($piutang)
                ->addIndexColumn()
                ->addColumn('customer_nama', function ($data) {
                    return $data->customer->nama;
                })
                ->addColumn('action', function ($data) {
                    $button = '<a href="javascript:void(0)" id="btn-bayar" data-id="'.$data->id.'" class="btn btn-info btn-sm">Bayar</a>';

                    return $button;
                })
                ->make(true);
        }
        return view('menu.jurnal-piutang.index');

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
        $piutang = Jual::find($id);

        return response()->json([
            'success' => true,
            'message' => 'Pembayaran berhasil',
            'data' => $piutang,
        ]);
    }


    public function edit(string $id)
    {
        //
    }


    public function update(Request $request, string $id)
    {
        // $piutang = Jual::find($id);
        $piutang = Jual::with('customer')->find($id);
    
        // $piutang->update([
        //     'nama' => $request->nama,
        //     'keterangan' => $request->keterangan,
        // ]);

        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Diupdate!',
            'data' => $piutang,
        ]);
    }


    public function destroy(string $id)
    {
        //
    }
}