<?php

namespace App\Http\Controllers;

use App\Models\Piutang;
use Illuminate\Http\Request;

class ReportPembayaranPiutangController extends Controller
{
    public function index(Request $request)
    {
        $report_piutang = Piutang::with(['jual'])->where('keterangan', 'cash')->orderBy('id', 'desc');

        if ($request->ajax()) {
            return datatables()->of($report_piutang)
                ->addIndexColumn()
                ->make(true);
        }

        return view('report.pembayaran-piutang.index');
    }

    public function create() {}

    public function store(Request $request) {}

    public function show(string $id) {}

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id) {}

    public function destroy(string $id) {}
}
