<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KategoriController extends Controller
{
    public function index(Request $request)
    {
        $kategori = Kategori::orderBy('id', 'asc');

        if ($request->ajax()) {
            return datatables()->of($kategori)
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

        return view('master.kategori.index', compact('kategori'));
    }

    public function create()
    {
        return view('master.kategori.index');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // check if data exists
        $check = Kategori::where('nama', $request->nama)->first();

        if ($check) {
            return response()->json([
<<<<<<< HEAD
                'success' => false,
                'message' => 'Kategori sudah ada',
=======
                'success' => true,
                'message' => 'Kategori berhasil ditambahkan',
>>>>>>> 740c836f5831ad44e195900b2c7a38f81e7166e0
            ]);
        }

        $data = $request->all();

        Kategori::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Kategori berhasil ditambahkan',
        ]);

    }

    public function show($id)
    {
        $kategori = Kategori::find($id);

        return response()->json([
            'success' => true,
            'data' => $kategori,
        ]);
    }

    public function edit($id)
    {
<<<<<<< HEAD
        //
=======
        $kategori = Kategori::find($id);

        return view('master.kategori.index', compact('kategori'));
>>>>>>> 740c836f5831ad44e195900b2c7a38f81e7166e0
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

<<<<<<< HEAD
        

=======
>>>>>>> 740c836f5831ad44e195900b2c7a38f81e7166e0
        $kategori = Kategori::find($id);
        $kategori->update([
            'nama' => $request->nama,
            'keterangan' => $request->keterangan,
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Kategori berhasil diedit',
            ]);
        }
<<<<<<< HEAD
=======

        return redirect()->route('master.kategori.index')->with('success', 'Kategori berhasil diupdate');
>>>>>>> 740c836f5831ad44e195900b2c7a38f81e7166e0
    }

    public function destroy($id, Request $request)
    {
        Kategori::where('id', $id)->delete();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Kategori berhasil dihapus',
            ]);
        }

<<<<<<< HEAD
=======
        return redirect()->route('master.kategori.index')->with('success', 'Kategori berhasil dihapus');
>>>>>>> 740c836f5831ad44e195900b2c7a38f81e7166e0
    }
}
