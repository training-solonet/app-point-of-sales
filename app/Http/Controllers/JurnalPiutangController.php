<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Jual;
use App\Models\Piutang;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class JurnalPiutangController extends Controller
{
    public function index(Request $request)
    {
        $piutang = Jual::with(['customer'])->where('status', 'piutang')
            ->orderBy('bayar', 'desc');

        if ($request->ajax()) {
            return datatables()->of($piutang)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $button = '<a href="javascript:void(0)" id="btn-bayar" data-id="' . $data->id . '" data-bs-target="#myModal" class="btn btn-info btn-sm">Bayar</a>';
                    $button .= '&nbsp;&nbsp;';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('menu.jurnal-piutang.index');

    }

    public function create()
    {
    }


    public function store(Request $request)
    {
    }


    public function show(string $id)
    {
        $piutang = Jual::with('customer')->find($id);

        if (!$piutang) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        $belumDiBayar = $piutang->total - $piutang->bayar;

        return response()->json([
            'success' => true,
            'data' => $piutang,
            'belum_dibayar' => $belumDiBayar
        ]);
    }


    public function edit(string $id)
    {
    }


    public function update(Request $request, string $id)
    {

        $validator = Validator::make($request->all(), [
            'bayar' => 'required|numeric'
        ]);
    
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
    
        $piutang = Jual::find($id);
        $totalbayar = $piutang->bayar + $request->bayar;
    
        $piutang->update([
            'bayar' => $totalbayar
        ]);
    
        // Check if payment is completed
        if ($totalbayar >= $piutang->total) {
            $piutang->update([
                'status' => 'cash'
            ]);
    
            Piutang::create([
                'jual_id' => $piutang->id,
                'keterangan' => 'Pembayaran Piutang Lunas',
            ]);
    
            return response()->json([
                'success' => true,
                'message' => 'Pembayaran berhasil diupdate, Piutang Lunas'
            ]);
        }
    
        return response()->json([
            'success' => true,
            'message' => 'Pembayaran berhasil diupdate'
        ]);
    }


    public function destroy(string $id)
    {
    }
}