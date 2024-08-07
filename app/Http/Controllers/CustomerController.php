<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $customer = Customer::orderBy('id', 'desc');

        if ($request->ajax()) {
            return datatables()->of($customer)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $button = '<a href="javascript:void(0)" id="btn-edit-post" data-id="'.$data->id.'" class="btn btn-warning btn-sm">Edit</a>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<a href="javascript:void(0)" id="btn-delete" data-id="'.$data->id.'" class="btn btn-danger btn-sm">Delete</a>';

                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('master.customer.index');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'alamat' => 'required',
            'no_hp' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $check = Customer::where('nama', $request->nama)->first();

        if ($check) {
            return response()->json([
                'success' => false,
                'message' => 'Data sudah ada!',
            ]);
        }

        $customer = Customer::create([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Disimpan!',
            'data' => $customer,
        ]);
    }

    public function show($id)
    {
        $customer = Customer::find($id);

        return response()->json([
            'success' => true,
            'message' => 'Detail Data Satuan',
            'data' => $customer,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'alamat' => 'required',
            'no_hp' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $customer = Customer::find($id);
        $check = Customer::where('nama', $request->nama)->where('id', '!=', $id)->first();

        if ($check) {
            return response()->json([
                'success' => false,
                'message' => 'Data sudah ada!',
            ]);
        }

        $customer->update([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Diupdate!',
            'data' => $customer,
        ]);
    }

    public function destroy(string $id, Request $request)
    {
        customer::find($id)->delete();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'data berhasil dihapus!',
            ]);
        }
    }
}
