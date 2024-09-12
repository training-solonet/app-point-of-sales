<?php

namespace App\Http\Controllers;

use App\Models\Jual;
use App\Models\Customer;
use App\Services\PrintService;
use Illuminate\Http\Request;
use App\Models\DetJual;
use App\Models\Stok;
// use Illuminate\Container\Attributes\DB;
use Illuminate\Support\Facades\DB;  // Pastikan ini ada di bagian atas file


class DashboardController extends Controller
{
    public function index()
    {

        // Menghitung jumlah total
        $totalCustomer = Customer::count();
        $totalStok = Stok::count();
        $totalAset = Stok::sum('harga_beli');
        // $totalAset = Stok::sum(DB::raw('harga_beli * jumlah'));

        // grafik penjualan dan pembelian
        $penjualanData = DetJual::join('jual', 'det_jual.jual_id', '=', 'jual.id')
            ->selectRaw('SUM(det_jual.harga_jual * det_jual.qty) as total_penjualan')
            ->groupByRaw('MONTH(jual.tanggal)')
            ->orderByRaw('MONTH(jual.tanggal)')
            ->pluck('total_penjualan');

        $pembelianData = DetJual::join('jual', 'det_jual.jual_id', '=', 'jual.id')
            ->selectRaw('SUM(det_jual.harga_beli * det_jual.qty) as total_pembelian')
            ->groupByRaw('MONTH(jual.tanggal)')
            ->orderByRaw('MONTH(jual.tanggal)')
            ->pluck('total_pembelian');

        $penjualanData = $penjualanData->map(function ($item) {
            return (float) $item;
        });

        $pembelianData = $pembelianData->map(function ($item) {
            return (float) $item;
        });
        //grafik penjualan dan pembelian end

        return view('menu.dashboard.index', compact('penjualanData', 'pembelianData', 'totalCustomer', 'totalStok', 'totalAset'));

    }

    public function create()
    {
    }

    public function store(Request $request)
    {
    }

    public function show($id)
    {
        $invo = Jual::with(['det_jual.barang'])->find($id);

        $header = "-----------------------------\n"
            . 'DATE: ' . now()->format('d-M-Y h:i:s A') . "\n"
            . "CASHIER: Admin\n"
            . '-----------------------------';

        $items = [];
        $printService = new PrintService;

        foreach ($invo->det_jual as $det) {
            $itemLine = $printService->formatItemLine(
                $det->barang->nama,
                $det->qty,
                number_format($det->harga_jual, 2),
                number_format($det->qty * $det->harga_jual, 2)
            );
            $items[] = $itemLine;
        }

        $totals = [];
        $totals[] = $printService->formatTotalLine('Sub Total', number_format($invo->total, 2));
        $totals[] = $printService->formatTotalLine('Discount', number_format($invo->discount, 2));

        $printService->printReceipt('SoloNet', $header, $items, $totals);

        return response()->json(['status' => 'success']);
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

