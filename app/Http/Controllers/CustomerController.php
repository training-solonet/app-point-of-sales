<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;


class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customer = customer::all();
        return view('master.customer.index', ['data' => $customer]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('master.customer.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        customer::create($request->all());
        return redirect('/master/customer');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // $customer = customer::find($id);
        // return view('siswa.edit', ['data' => $customer]);
        dd($id);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $customer = customer::find($id);
        $customer->update($request->except('_token', 'proses'));
        return redirect('/master/customer');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $customer = customer::find($id);
        $customer->delete();
        return redirect('/master/customer');
    }
}