<?php

namespace App\Http\Controllers;

use App\Models\Jual;
use App\Services\PrintService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Smalot\PdfParser\Parser;

class DashboardController extends Controller
{
    public function index() {}

    public function create() {}

    public function store(Request $request) {}

    public function show($id)
    {
        $invo = Jual::with(['det_jual.barang'])->find($id);

        $header = "SoloNet\n"
                . "-----------------------------\n"
                . "DATE: " . now()->format('d-M-Y h:i:s A') . "\n"
                . "CASHIER: Admin\n"
                . "-----------------------------";

        $items = [];
        $printService = new PrintService();

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
        $totals[] = $printService->formatTotalLine('VAT @ 17.5%', number_format($invo->vat, 2));
        $totals[] = $printService->formatTotalLine('Bill Total', number_format($invo->bill_total, 2));
        $totals[] = $printService->formatTotalLine('Tendered', number_format($invo->tendered, 2));
        $totals[] = $printService->formatTotalLine('Balance', number_format($invo->balance, 2));

        // Using PrintService to print the receipt
        $printService->printReceipt('Invoice Example', $header, $items, $totals);

        return response()->json(['status' => 'success']);

    }

    public function edit(string $id) {}

    public function update(Request $request, string $id) {}

    public function destroy(string $id) {}
}
