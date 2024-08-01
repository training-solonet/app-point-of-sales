<?php

namespace App\Http\Controllers;

use App\Models\Satuan;
use Illuminate\Http\Request;

class SatuanController extends Controller
{
    public function index()
    {
        $satuan = Satuan::all();
        return view('master.satuan.index', compact('satuan'));
    }

    public function create()
    {
        return view('master.satuan.index');
    }

    public function store(Request $request)
    {
        // validasi input
        $validated = $request->validate([
            'nama' => 'required',
        ]);

        Satuan::create($request->except('_token', 'proses'));
        return redirect('/master/satuan')->with('success', 'Data berhasil disimpan');
    }

    public function edit($id)
    {
        $satuan = Satuan::find($id);
        return view('master.satuan.edit', compact('satuan'));
    }

    public function show(string $id)
    {
        // Implementasi jika diperlukan
    }

    public function update(Request $request, string $id)
    {
        $satuan = Satuan::find($id);
        $satuan->update($request->except('_token', 'proses'));
        return redirect('/master/satuan');
    }

    public function destroy(string $id)
    {
        $satuan = Satuan::find($id);
        $satuan->delete();
        return redirect('/master/satuan');
    }
}