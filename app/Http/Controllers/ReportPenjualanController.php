<?php

namespace App\Http\Controllers;

use App\Models\Jual;
use App\Models\Customer;
use Illuminate\Http\Request;

class ReportPenjualanController extends Controller
{

    public function index(Request $request)
    {
        $penjualan = Jual::with(['customer']);

        if ($request->ajax()) {
            if ($request->has('filter')) {
                $filter = $request->get('filter');

                switch ($filter) {
                    case 'no_faktur':
                        $penjualan->orderBy('no_faktur', 'desc');
                        break;
                    case 'nama_customer':
                        $penjualan->join('customer', 'jual.customer_id', '=', 'customer.id')
                            ->select('jual.*', 'customer.nama as customer_nama')
                            ->orderBy('customer.nama');
                        break;
                    case 'tanggal_terbaru':
                        $penjualan->orderBy('tanggal', 'desc');
                        break;
                    case 'tanggal_terlama':
                        $penjualan->orderBy('tanggal', 'asc');
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
                        $penjualan->orderBy('id', 'desc');
                        break;
                }
            }


            return datatables()->of($penjualan)
                ->addIndexColumn()
                ->make(true);
        }

        return view('report.penjualan.index');
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
    }

    public function show(string $id)
    {
    }

    public function edit(string $id)
    {
    }

    public function update(Request $request, string $id)
    {
    }

    public function destroy(string $id)
    {
    }
}
