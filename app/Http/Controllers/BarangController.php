<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index()
    {
        $barang = Barang::latest()->paginate(1086);
        return view('master.barang.index', compact('barang'))
                    ->with('i', (request()->input('page', 1)-1)*5);
    }

    public function create()
    {
        return view('master.barang.index');
    }

    public function store(Request $request)
    {
        Barang::create($request->all());
        return redirect('/master/barang');
    }

    
    public function show(string $id)
    {
        $barang = Barang::with('kategori', 'satuan')->find($id);
        return view('master.barang.index')->with(compact('barang'));
    }

    public function edit(string $id)
    {
        $barang=Barang::find($id);
        return view('master.barang.index', compact('barang'));
    }

    public function update(Request $request, string $id)
    {
        $barang = Barang::find($id);
        $barang->update($request->except('_token', 'proses'));
        return redirect('master/barang');
    }

    public function destroy(string $id)
    {
        Barang::find($id)->delete();
        return redirect()->route('master.barang.index')->with('success', 'barang deleted successfully');
    }
}
