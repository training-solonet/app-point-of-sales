<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Jual;
use Illuminate\Http\Request;

class ReportPenjualanController extends Controller
{
    public function index(Request $request)
    {
        $penjualan = Jual::with(['customer']);
        $customer = Customer::all();
        
        if($request->has('start') && $request->has('end')) {
            $startDate = \Carbon\Carbon::createFromFormat('d M, Y', $request->start)->startOfDay();
            $endDate = \Carbon\Carbon::createFromFormat('d M, Y', $request->end)->endOfDay();
            $penjualan->whereBetween('tanggal', [$startDate, $endDate]);
        }
        
        if($request->has('filter_customer') && !empty($request->filter_customer)) {
            $penjualan->whereIn('customer_id', $request->filter_customer);
        }
        
        if($request->has('min') && $request->has('max')) {
            $min = str_replace('.', '', $request->min);
            $max = str_replace('.', '', $request->max);
            
            $penjualan->whereBetween('total', [$min, $max]);
        }
        
        if ($request->ajax()) {
            return datatables()->of($penjualan)
                ->addIndexColumn()
                ->make(true);
        }
        
        return view('report.penjualan.index', compact('customer'));
    }

    public function create() {}

    public function store(Request $request) {}

    public function show(string $id) {}

    public function edit(string $id) {}

    public function update(Request $request, string $id) {}

    public function destroy(string $id) {}
}
