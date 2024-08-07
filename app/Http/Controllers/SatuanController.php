<?php

namespace App\Http\Controllers;

use App\Models\Satuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SatuanController extends Controller
{
    public function index(Request $request)
    {
        $satuan = Satuan::orderBy('id', 'desc');

        // datatable
        if ($request->ajax()) {
            return datatables()->of($satuan)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $button = '<a href="javascript:void(0)" id="btn-edit-post" data-id="'.$data->id.'" class="btn btn-warning btn-sm">Edit</a>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<a href="javascript:void(0)" id="btn-delete" data-id="'.$data->id.'" class="btn btn-danger btn-sm">Delete</a>';

                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('master.satuan.index');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $check = Satuan::where('nama', $request->nama)->first();

        if ($check) {
            return response()->json([
                'success' => false,
                'message' => 'Data sudah ada!',
            ]);
        }

        $satuan = Satuan::create([
            'nama' => $request->nama,
            'keterangan' => $request->keterangan,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Disimpan!',
            'data' => $satuan,
        ]);
    }

    public function show($id)
    {
        $satuan = Satuan::find($id);

        return response()->json([
            'success' => true,
            'message' => 'Detail Data Satuan',
            'data' => $satuan,
        ]);
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $satuan = Satuan::find($id);
        $check = Satuan::where('nama', $request->nama)->where('id', '!=', $id)->first();

        if ($check) {
            return response()->json([
                'success' => false,
                'message' => 'Data sudah ada!',
            ]);
        }

        $satuan->update([
            'nama' => $request->nama,
            'keterangan' => $request->keterangan,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Diupdate!',
            'data' => $satuan,
        ]);
    }

    public function destroy($id, Request $request)
    {
        Satuan::find($id)->delete();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil dihapus!',
            ]);
        }
    }
}
