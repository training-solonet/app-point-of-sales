<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Support\Facades\DB;
use App\Models\DetailPembelian;
use App\Models\Distributor;
use App\Models\Pembelian;
use App\Models\Purchase_order;
use Illuminate\Http\Request;

class BarangMasukController extends Controller
{
    public function index(Request $request)
    {
        $pembelian = Pembelian::with(['purchase_orders.distributor'])
            ->select('pembelian.id', 'pembelian.no_invoice', 'pembelian.tgl_beli', 'pembelian.kode_po', 'pembelian.pengguna', DB::raw('SUM(detail_pembelian.qty) as total_barang'))
            ->join('detail_pembelian', 'detail_pembelian.no_invoice', '=', 'pembelian.no_invoice')
            ->groupBy('pembelian.id', 'pembelian.no_invoice', 'pembelian.tgl_beli', 'pembelian.kode_po', 'pembelian.pengguna')
            ->orderBy('id', 'desc')
            ->get();

        if ($request->ajax()) {
            return datatables()->of($pembelian)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $button = '<a href="/menu/barang-masuk/' . $data->id . '" class="btn btn-info waves-effect waves-light">Detail</button>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $distributor = Distributor::all();
        $detailPembelian = DetailPembelian::all();
        $po = Purchase_order::all();
        return view('menu.barang-masuk.index', compact('distributor', 'detailPembelian', 'po'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(string $id, Request $request)
    {
        if ($request->ajax()) {
            $pembelian = Pembelian::with(['purchase_orders.distributor', 'detail_pembelian.barang'])
                ->where('id', $id)
                ->first();

            if (!$pembelian) {
                return response()->json(['error' => 'data not found'], 404);
            }

            $data = $pembelian->detail_pembelian->map(function ($detail, $index) {
                return [
                    'index' => $index + 1,
                    'nama_barang' => $detail->barang->nama,
                    'qty' => $detail->qty,
                    'harga_satuan' => $detail->harga_satuan,
                    'total_harga' => $detail->qty * $detail->harga_satuan
                ];
            });

            return datatables()->of($data)
            ->addIndexColumn()
            ->make(true);
        }

        return view('menu.barang-masuk.detail', compact('id'));
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
