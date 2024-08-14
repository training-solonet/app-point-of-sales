<?php

namespace App\Http\Controllers;

use App\Models\Piutang;
use App\Models\Customer;
use Illuminate\Http\Request;

class ReportPembayaranPiutangController extends Controller
{
    public function index(Request $request)
    {
        $report_piutang = Piutang::with(['jual'])->where('keterangan', 'cash');

        if ($request->has('start') && $request->has('end')) {
            $startDate = $request->input('start');
            $endDate = $request->input('end');
    
            if (!empty($startDate) && !empty($endDate)) {
                $report_piutang->whereBetween('tanggal', [$startDate, $endDate]);
            }
        }
        if ($request->ajax()) {
            if ($request->has('filter')) {
                $filter = $request->get('filter');

                switch ($filter) {
                    case 'no_faktur':
                        $report_piutang->orderByRaw('CAST(jual_id AS UNSIGNED) DESC');
                        break;
                    case 'tanggal_terbaru':
                        $report_piutang->orderByRaw('CAST(tanggal AS DATE) DESC');
                        break;
                    case 'tanggal_terlama':
                        $report_piutang->orderByRaw('CAST(tanggal AS DATE) ASC');
                        break;
                    case 'pembayaran_terbesar':
                        $report_piutang->orderBy('pembayaran', 'desc');
                        break;
                    case 'pembayaran_terkecil':
                        $report_piutang->orderBy('pembayaran', 'asc');
                        break;
                    default:
                        $report_piutang->orderBy('id', 'asc');
                        break;
                }
            }

            return datatables()->of($report_piutang)
                ->addIndexColumn()
                ->make(true);
        }

        return view('report.pembayaran-piutang.index');
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
        //
    }

    public function update(Request $request, string $id)
    {
    }

    public function destroy(string $id)
    {
    }
}
