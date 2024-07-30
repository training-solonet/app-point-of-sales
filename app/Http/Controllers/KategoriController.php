<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kategori = Kategori::latest()->paginate(10);
        return view('master.kategori.index', compact('kategori'))
                    ->with('i', (request()->input('page', 1)-1)*5);
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('master.kategori.index');
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $kategori = new Kategori();

        $kategori->nama = $request->nama;
        $kategori->keterangan = $request->keterangan;

        return redirect('master.kategori.index');
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $kategori = Kategori::with('nama', 'keterangan')->find($id);
        return view('master.kategori.index')->with(compact('kategori'));
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $kategori = Kategori::find($id);
        return response()->json($kategori);
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $kategori = Kategori::find($id);

        $kategori->nama = $request->nama;
        $kategori->keterangan = $request->keterangan;

        $kategori->save();

        return redirect('master.kategori.index');
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Kategori::find($id)->delete();
        return redirect()->route('master.kategori.index')->with('success', 'barang deleted');
        //
    }
}
