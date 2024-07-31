<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        $kategori = Kategori::latest()->paginate(10);
        return view('master.kategori.index', compact('kategori'))
                    ->with('i', (request()->input('page', 1)-1)*5);
    }

    public function create()
    {
        return view('master.kategori.index');
    }

    public function store(Request $request)
    {
        Kategori::create($request->all());
        return redirect('/master/kategori');
    }

    public function show(string $id)
    {
        $kategori = Kategori::with('nama', 'keterangan')->find($id);
        return view('master.kategori.index')->with(compact('kategori'));
    }

    public function edit(string $id)
    {
        $kategori=Kategori::find($id);
        return view('master.kategori.index', compact('kategori'));
    }

    public function update(Request $request, string $id)
    {
        $kategori = Kategori::find($id);
        $kategori->update($request->except(['_token', 'proses']));
        return redirect('/master/kategori');
    }

    public function destroy(string $id)
    {
        Kategori::find($id)->delete();
        return redirect()->route('master.kategori.index')->with('success', 'kategori deleted');
    }
}
