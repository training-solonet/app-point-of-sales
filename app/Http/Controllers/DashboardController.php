<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\DetJual;
use App\Models\Jual;
use App\Models\Stok;
use App\Models\User;
use App\Services\PrintService;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class DashboardController extends Controller
{
    public function index()
    {
        // Menghitung jumlah total
        $totalCustomer = Customer::count();
        $totalStok = Stok::count();
        $totalAset = Stok::sum('harga_beli');
        $currentMonth = now()->month;
        $penjualanBulanan = Jual::whereMonth('tanggal', $currentMonth)->count();

        // Grafik laba dan penjualan pembelian
        $penjualanData = array_fill(0, 12, 0);
        $pembelianData = array_fill(0, 12, 0);
        $totalLaba = array_fill(0, 12, 0);

        $penjualan = DetJual::join('jual', 'det_jual.jual_id', '=', 'jual.id')
            ->selectRaw('MONTH(jual.tanggal) as bulan, SUM(det_jual.harga_jual * det_jual.qty) as total_penjualan')
            ->groupByRaw('MONTH(jual.tanggal)')
            ->orderByRaw('MONTH(jual.tanggal)')
            ->get();

        $pembelian = DetJual::join('jual', 'det_jual.jual_id', '=', 'jual.id')
            ->selectRaw('MONTH(jual.tanggal) as bulan, SUM(det_jual.harga_beli * det_jual.qty) as total_pembelian')
            ->groupByRaw('MONTH(jual.tanggal)')
            ->orderByRaw('MONTH(jual.tanggal)')
            ->get();

        $laba = DetJual::join('jual', 'det_jual.jual_id', '=', 'jual.id')
            ->selectRaw('MONTH(jual.tanggal) as bulan, SUM((det_jual.harga_jual - det_jual.harga_beli) * det_jual.qty) as total_laba')
            ->groupByRaw('MONTH(jual.tanggal)')
            ->orderByRaw('MONTH(jual.tanggal)')
            ->get();

        foreach ($penjualan as $data) {
            $penjualanData[$data->bulan - 1] = (float) $data->total_penjualan;
        }

        foreach ($pembelian as $data) {
            $pembelianData[$data->bulan - 1] = (float) $data->total_pembelian;
        }

        foreach ($laba as $data) {
            $totalLaba[$data->bulan - 1] = (float) $data->total_laba;
        }

        return view('menu.dashboard.index', compact('penjualanData', 'pembelianData', 'totalLaba', 'totalCustomer', 'totalStok', 'totalAset', 'penjualanBulanan'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request) {}

    public function show($id)
    {
        $invo = Jual::with(['det_jual.barang'])->find($id);

        $header = "-----------------------------\n"
            .'DATE: '.now()->format('d-M-Y h:i:s A')."\n"
            ."CASHIER: Admin\n"
            .'-----------------------------';

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
        $user = User::find(1);

        if (! $user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $customClaims = [
            'name' => $user->name,
            'iat' => now()->timestamp,
            'exp' => now()->addDay()->timestamp,
        ];

        $token = JWTAuth::fromUser($user, $customClaims);

        return response()->json([
            'token' => $token,
            'detail' => $customClaims,
        ]);
    }

    public function update(Request $request, string $id) {}

    public function destroy(string $id) {}
}
