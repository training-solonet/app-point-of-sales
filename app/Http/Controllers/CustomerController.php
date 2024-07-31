<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{

    public function index()
    {
        $customer = customer::all();
        return view('master.customer.index', compact('customer'));
    }


    public function create()
    {
        return view('master.customer.index');
    }


    public function store(Request $request)
    {
        customer::create($request->all());
        return redirect('/master/customer');
    }

    public function edit($id)
    {
        $customer = customer::find($id);
        return view('master.customer.index', compact('customer'));
    }


    public function update(Request $request, $id)
    {
        $customer = customer::find($id);
        $customer->update($request->except('_token', 'proses'));
        return redirect('/master/customer');
    }


    public function destroy($id)
    {
        customer::find($id)->delete();
        return redirect('/master/customer');
    }
}