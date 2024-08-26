<?php

namespace App\Http\Controllers;

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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('menu.barang-masuk.detail');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
