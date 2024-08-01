<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index(Request $request)
    {
        $kategori = Kategori::orderBy('id', 'asc');

        if ($request->ajax()) {
            return datatables()->of($kategori)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $button = '<button type="button" class="btn btn-primary btn-sm" data-id="'. $data->id .'"data-bs-toggle="modal" data-bs-target="#UpModal"> Edit</button>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<button type="submit" class="btn btn-danger btn-sm" id="btn-delete" data-id="'. $data->id .'">Delete</button>';
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
        $validated = $request->validate([
            'nama' => 'required',
        ]);

        Kategori::create($request->all());
        return redirect('/master/kategori')->with('success', 'kategori berhasil dibuat');
    }

    public function show(string $id)
    {
        $kategori = Kategori::with('nama', 'keterangan')->find($id);
        return view('master.kategori.index')->with(compact('kategori'));
    }

    public function edit(string $id)
    {
        $kategori = Kategori::find($id);
        return view('master.kategori.index', compact('kategori'));
    }

    public function update(Request $request, string $id)
    {
        $kategori = Kategori::find($id);
        $kategori->update($request->except(['_token', 'proses']));
        return redirect('/master/kategori');
    }

    public function destroy(string $id, Request $request)
    {
        $kategori = Kategori::findOrFail($id);
        $kategori->delete();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Kategori berhasil dihapus'
            ]);
        }

        return redirect('/master/kategori')->with('success', 'Kategori berhasil dihapus');
    }
}
