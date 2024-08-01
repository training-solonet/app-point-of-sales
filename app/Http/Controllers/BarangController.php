<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        $barang = Barang::with(['kategori', 'satuan'])
        ->orderBy('id', 'asc');

        if ($request->ajax()) {
            return datatables()->of($barang)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $button = '<button type="button" class="btn btn-primary btn-sm edit-btn" data-id="' . $data->id . '" data-bs-toggle="modal" data-bs-target="#UpModal"> Edit</button>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<button type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm">Delete</button>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('master.barang.index');
    }

    public function create()
    {
        return view('master.barang.index');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode' => 'required',
            'nama' => 'required',
            'kategori' => 'required',
            'satuan' => 'required',
        ]);

        Barang::create($request->all());
        return redirect('/master/barang')->with('success', 'barang berhasil dibuat');
    }


    public function show(string $id)
    {
        $barang = Barang::with(['kategori', 'satuan'])->find($id);

    if ($barang) {
        return response()->json([
            'success' => true,
            'message' => 'Barang found',
            'data' => $barang
        ]);
    } else {
        return response()->json([
            'success' => false,
            'message' => 'Barang not found'
        ]);
    }
    }

    public function edit(string $id)
    {
        // $barang = Barang::find($id);
        // return view('master.barang.index', compact('barang'));
        $barang = Barang::with('kategori', 'satuan')->find($id);
        return response()->json($barang);
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'kode' => 'required',
            'nama' => 'required',
            'id_kategori' => 'required',
            'id_satuan' => 'required',
        ]);

        Barang::find($id)->update([
            'kode' => $request->kode,
            'part_number' => $request->part_number,
            'nama' => $request->nama,
            'id_kategori' => $request->id_kategori,
            'id_satuan' => $request->id_satuan,
            'stok' => $request->stok,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Barang updated',
            'data' => Barang::with('kategori', 'satuan')->find($id)
        ]);
    }

    public function destroy(string $id)
    {
        Barang::find($id)->delete();
        return redirect()->route('master.barang.index')->with('success', 'barang deleted successfully');
    }
}
