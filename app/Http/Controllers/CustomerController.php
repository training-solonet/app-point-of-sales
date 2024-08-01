<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $customer = Customer::orderBy('id', 'asc');

        // datatable
        if ($request->ajax()) {
            return datatables()->of($customer)
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

        return view('master.customer.index');
    }


    public function create()
    {
        return view('master.customer.index');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|max:255',
            'alamat' => 'required|max:255',
            'no_hp' => 'required|max:255',
        ]);

        customer::create($request->all());
        return redirect('/master/customer')->with('berhasil', 'Item berhasil Tambahkan!');
    }

    public function edit($id)
    {
        $customer = customer::find($id);
        return view('master.customer.index', compact('customer'));
    }

    public function show(string $id)
    {
        // Implementasi jika diperlukan
    }



    public function update(Request $request, $id)
    {
        customer::find($id);
        return redirect('/master/customer');
    }


    public function destroy($id)
    {
        customer::find($id)->delete();
        return redirect('/master/customer')->with('berhasil', 'Item berhasil Dihapus!');
    }
}