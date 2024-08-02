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
                    $button = '<a href="javascript:void(0)" id="btn-edit" data-id="'. $data->id .'" data-bs-target="#UpModal" class="btn btn-primary btn-sm">Edit</a>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<a href="javascript:void(0)" id="btn-delete" data-id="'. $data->id .'" class="btn btn-danger btn-sm">Delete</a>';
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

        if($validated->fails()) {
            return redirect('/master/kategori')->with('error', 'kategori gagal dibuat');
        }

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
        $validated = $request->validate([
            'nama' => 'required',
        ]);

        if($validated->fails()) {
            return redirect('/master/kategori')->with('error', 'kategori gagal diupdate');
        }

        Kategori::where('id', $id)->update($request->all());

        return redirect('/master/kategori')->with('success', 'kategori berhasil diupdate');
    }

    public function destroy(string $id, Request $request)
    {
        Kategori::where('id', $id)->delete();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Kategori berhasil dihapus'
            ]);
        }
        return redirect()->route('master.kategori.index')->with('success', 'Kategori berhasil dihapus');
    }
}
