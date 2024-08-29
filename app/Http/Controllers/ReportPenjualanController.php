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

        if ($request->has('filter_customer') && ! empty($request->filter_customer)) {
            $penjualan->whereIn('customer_id', $request->filter_customer);
        }

        if ($request->has('start') && $request->has('end')) {
            $startDate = $request->input('start');
            $endDate = $request->input('end');

            if (! empty($startDate) && ! empty($endDate)) {
                $penjualan->whereBetween('tanggal', [$startDate, $endDate]);
            }
        }
        if ($request->ajax()) {
            if ($request->has('filter')) {
                $filter = $request->get('filter');

                switch ($filter) {
                    case 'no_faktur':
                        $penjualan->orderByRaw('CAST(no_faktur AS UNSIGNED) DESC');
                        break;
                    case 'nama_customer':
                        $penjualan->join('customer', 'jual.customer_id', '=', 'customer.id')
                            ->select('jual.*', 'customer.nama as customer_nama')
                            ->orderBy('customer.nama');
                        break;
                    case 'tanggal_terbaru':
                        $penjualan->orderByRaw('CAST(tanggal AS DATE) DESC');
                        break;
                    case 'tanggal_terlama':
                        $penjualan->orderByRaw('CAST(tanggal AS DATE) ASC');
                        break;
                    case 'total_terbesar':
                        $penjualan->orderBy('total', 'desc');
                        break;
                    case 'total_terkecil':
                        $penjualan->orderBy('total', 'asc');
                        break;
                    case 'sudah_terbayar':
                        $penjualan->where('bayar', '>', 0)->orderBy('bayar', 'desc');
                        break;
                    case 'belum_terbayar':
                        $penjualan->where('bayar', 0);
                        break;
                    case 'bank':
                        $penjualan->where('status', 'bank');
                        break;
                    case 'cash':
                        $penjualan->where('status', 'cash');
                        break;
                    case 'piutang':
                        $penjualan->where('status', 'piutang');
                        break;
                    default:
                        $penjualan->orderBy('id', 'asc');
                        break;
                }
            }

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
