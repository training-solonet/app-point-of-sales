<?php

namespace App\Http\Controllers;

use App\Models\Jual;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Services\PrintService;
use Smalot\PdfParser\Parser;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        
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

        $data = [
            'title' => 'Invoice Example',
            'invoice' => $invo,
        ];

        $pdf = PDF::loadView('invoice.show', $data)
            ->setPaper([0, 0, 216, 1000]);

        $pdfPath = storage_path('app/public/invoice.pdf');

        $pdf->save($pdfPath);

        $parser = new Parser();
        $pdfText = $parser->parseFile($pdfPath)->getText();

        // Membuat instance PrintService
        $printService = new PrintService;

        // Menggunakan service untuk mencetak
        $text = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam non felis eu est pretium pretium sit amet quis tellus. Aenean dignissim tortor a magna aliquet vulputate. Pellentesque hendrerit pharetra tempor. Maecenas ipsum ex, venenatis vitae arcu quis, convallis fringilla felis. Etiam sed cursus nibh. Praesent vel dolor accumsan, sodales risus at, tincidunt ex. Vestibulum vitae metus laoreet, venenatis tortor vel, aliquam lectus. Sed iaculis, lectus id porta tincidunt, erat elit eleifend ante, at varius mauris dolor at risus. Pellentesque ut sapien id nibh finibus semper consectetur a est. Nam elementum vel turpis eget dignissim.';
        $printService->printText($text);

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
