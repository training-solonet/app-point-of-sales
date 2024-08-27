<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jurnal_harian;
use Illuminate\Support\Facades\Validator;


class JurnalHarianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'tanggal' => 'required',
            'keterangan' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $jurnal = Jurnal_harian::create([
            'tanggal' => $request-> tanggal,
            'debit' => $request-> debit,
            'kredit' => $request-> kredit,
            'keterangan' => $request-> keterangan,
            'status' => $request-> status
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Disimpan!',
            'data' => $jurnal,
        ]);
    }

    /**
     * Display the specified resource.
     */
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
            'tanggal' => 'required|date',
            'keterangan' => 'required|string|max:255',
            'debit' => 'required|numeric',
            'kredit' => 'required|numeric',
            'status' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $jurnal = Jurnal_harian::find($id);
        
        $jurnal->update([
            'tanggal' => $request->tanggal,
            'keterangan' => $request->keterangan,
            'debit' => $request->debit,
            'kredit' => $request->kredit,
            'status' => $request->status
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
