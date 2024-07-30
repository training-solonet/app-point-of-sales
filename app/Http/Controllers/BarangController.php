<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $barang = Barang::latest()->paginate(1086);
        return view('master.barang.index', compact('barang'))
                    ->with('i', (request()->input('page', 1)-1)*5);
        // return view('master.barang.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Barang::updateOrCreate(
        //     ['id' => $request->barang_id],
        //     [
        //         'kode' => $request->kode,
        //         'part_number' => $request->part_number,
        //         'nama' => $request->nama,
        //         'id_kategori' => $request->id_kategori,
        //         'id_satuan' => $request->id_satuan,
        //         'stok' => $request->stok,
        //     ]
        // );

        // return response()->json(['success'=>'Barang saved successfully']);
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $barang = Barang::with('kategori', 'satuan')->find($id);
        return response()->json($barang);
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $barang = Barang::find($id);
        return response()->json($barang);
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Barang::find($id)->delete();
        return redirect()->route('master.barang.index')->with('success', 'barang deleted successfully');
        //
    }
}
