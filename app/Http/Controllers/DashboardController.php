<?php

namespace App\Http\Controllers;

use App\Models\Jual;
use App\Services\PrintService;
use Illuminate\Http\Request;
use App\Models\DetJual;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $penjualan = DetJual::with(['jual']);
        $pembelian = DetJual::with(['jual']);

        $penjualan = DetJual::selectRaw('MONTH(tanggal) as bulan, SUM(qty * harga_jual) as total_penjualan')
            ->groupBy('bulan')
            ->pluck('total_penjualan', 'bulan')
            ->toArray();

        $pembelian = DetJual::selectRaw('MONTH(tanggal) as bulan, SUM(qty * harga_beli) as total_pembelian')
            ->groupBy('bulan')
            ->pluck('total_pembelian', 'bulan')
            ->toArray();

        // Mengisi data dari Januari hingga Desember
        $bulan = range(1, 12);
        $dataPenjualan = [];
        $dataPembelian = [];

        // foreach ($bulan as $b) {
        //     $dataPenjualan[] = $penjualan[$b] ?? 0;  
        //     $dataPembelian[] = $pembelian[$b] ?? 0;  
        // }

        return view('menu.dashboard.index', compact('dataPenjualan', 'dataPembelian'));
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

