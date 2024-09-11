<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Satuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        $barang = Barang::with(['kategori', 'satuan'])
            ->orderBy('id', 'desc');

        if ($request->ajax()) {
            return datatables()->of($barang)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $button = '<a href="javascript:void(0)" id="btn-edit" data-bs-toggle="modal" data-id="'.$data->id.'" data-bs-target="#UpModal" class="btn btn-primary btn-sm">Edit</a>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<a href="javascript:void(0)" id="btn-delete" data-id="'.$data->id.'" class="btn btn-danger btn-sm">Delete</a>';

                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $kategori = Kategori::all();
        $satuan = Satuan::all();

        return view('master.barang.index', compact('kategori', 'satuan'));
    }

    public function create()
    {
        return view('master.barang.index');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'id_satuan' => 'required',
            'id_kategori' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // check if data exists
        $check = Barang::where('nama', $request->nama)->first();

        if ($check) {
            return response()->json([
                'success' => false,
                'message' => 'Barang sudah ada',
            ]);
        }

        $data = $request->all();

        Barang::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Barang berhasil ditambahkan',
        ]);
    }

    public function show(string $id)
    {
        $barang = Barang::find($id);

        return response()->json([
            'success' => true,
            'data' => $barang,
        ]);
    }

    public function edit(string $id) {}

    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $barang = Barang::find($id);
        $barang->update([
            'kode' => $request->kode,
            'part_number' => $request->part_number,
            'nama' => $request->nama,
            'id_satuan' => $request->id_satuan,
            'id_kategori' => $request->id_kategori,
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Barang berhasil diedit',
            ]);
        }

    }

    public function destroy(string $id, Request $request)
    {
        Barang::where('id', $id)->delete();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Barang berhasil dihapus',
            ]);
        }
    }
}
