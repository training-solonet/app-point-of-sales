<?php

namespace App\Http\Controllers;

use App\Models\Satuan;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class SatuanController extends Controller
{
    public function index(Request $request)
    {
        $satuan = Satuan::orderBy('id', 'asc');

        // datatable
        if ($request->ajax()) {
            return datatables()->of($satuan)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $button = '<button type="button" name="edit" id="' . $data->id . '" class="edit btn btn-warning btn-sm">Edit</button>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<button type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm">Delete</button>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('master.satuan.index');
    }

    public function create()
    {
        return view('master.satuan.index');
    }


    public function store(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'keterangan' => 'required|max:255',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //create post
        $satuan = Satuan::create([
            'nama' => $request->nama,
            'keterangan' => $request->keterangan,
        ]);

        //return response
        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Disimpan!',
            'data' => $satuan
        ]);
    }

    // Satuan::create($request->except('_token', 'proses'));
    // return redirect('/master/satuan')->with('berhasil', 'Item berhasil dibuat!');


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
        $satuan->update($request->all());
        return redirect('/master/satuan')->with('update', 'Item berhasil diperbarui!');
    }

    public function destroy(string $id)
    {
        $satuan = Satuan::find($id);
        $satuan->delete();
        return redirect('/master/satuan')->with('delete', 'Item berhasil dihapus!');
    }
}