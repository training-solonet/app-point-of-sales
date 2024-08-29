<?php

namespace App\Http\Controllers;

use App\Models\Jurnal_harian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JurnalHarianController extends Controller
{
    public function index(Request $request)
    {
        $jurnal = Jurnal_harian::all();

        if ($request->ajax()) {
            return datatables()->of($jurnal)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $button = '<a href="javascript:void(0)" id="btn-edit" data-id="' . $data->id . '" class="btn btn-warning btn-sm">Edit</a>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<a href="javascript:void(0)" id="btn-delete" data-id="' . $data->id . '" class="btn btn-danger btn-sm">Delete</a>';

                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('menu.jurnal-harian.index');
    }

    public function create()
    {
        $saldo = Jurnal_harian::where('status', 'cash')->sum('debit') - Jurnal_harian::where('status', 'cash')->sum('kredit');

        return response()->json([
            'success' => true,
            'saldo' => number_format($saldo),
        ]);

    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tanggal' => 'required|date',
            'jenis' => 'required|in:Pemasukan,Pengeluaran',
            'nominal' => 'required',
            'keterangan' => 'required|string',
            'status' => 'required|in:cash,bank',
            'debit' => 'required|numeric',
            'kredit' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $data = [
            'tanggal' => $request->input('tanggal'),
            'keterangan' => $request->input('keterangan'),
            'debit' => $request->input('debit'),
            'kredit' => $request->input('kredit'),
            'status' => $request->input('status'),
        ];

        Jurnal_harian::create($data);
        return response()->json(['success' => true, 'message' => 'Data berhasil disimpan.']);
    }

    public function show($id)
    {
        $jurnal = Jurnal_harian::find($id);
        if ($jurnal) {
            return response()->json([
                'success' => true,
                'data' => $jurnal,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan',
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'tanggal' => 'required',
            'debit' => 'required',
            'kredit' => 'required',
            'keterangan' => 'required',
            'status' => 'required',

        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $jurnal = Jurnal_harian::find($id);

        $jurnal->update([
            'tanggal' => $request->tanggal,
            'debit' => $request->debit,
            'kredit' => $request->kredit,
            'keterangan' => $request->keterangan,
            'status' => $request->status,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Diupdate!',
            'data' => $jurnal,
        ]);
    }

    public function destroy($id, Request $request)
    {
        Jurnal_harian::find($id)->delete();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil dihapus!',
            ]);
        }
    }
}
