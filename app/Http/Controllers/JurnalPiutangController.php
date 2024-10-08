<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Jual;
use App\Models\Piutang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JurnalPiutangController extends Controller
{
    public function index(Request $request)
    {
        $piutang = Jual::with(['customer'])->where('status', 'piutang');

        if ($request->has('filter_customer') && ! empty($request->filter_customer)) {
            $piutang->whereIn('customer_id', $request->filter_customer);
        }

        if ($request->has('start') && $request->has('end')) {
            $startDate = $request->input('start');
            $endDate = $request->input('end');

            if (! empty($startDate) && ! empty($endDate)) {
                $piutang->whereBetween('tanggal', [$startDate, $endDate]);
            }
        }

        if ($request->ajax()) {
            return datatables()->of($piutang->get())
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $button = '<a href="javascript:void(0)" id="btn-bayar" data-id="'.$data->id.'" data-bs-target="#myModal" class="btn btn-info btn-sm">Bayar</a>';
                    $button .= '&nbsp;&nbsp;';

                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $customer = Customer::all();

        return view('menu.jurnal-piutang.index', compact('customer'));
    }

    public function create() {}

    public function store(Request $request) {}

    public function show(string $id)
    {
        $piutang = Jual::with('customer')->find($id);

        if (! $piutang) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        $belumDiBayar = $piutang->total - $piutang->bayar;

        return response()->json([
            'success' => true,
            'data' => $piutang,
            'belum_dibayar' => $belumDiBayar,
        ]);
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {

        $validator = Validator::make($request->all(), [
            'bayar' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 400);
        }

        $piutang = Jual::find($id);

        if (! $piutang) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        $bayarAmount = $request->input('bayar');
        $newBayarTotal = $piutang->bayar + $bayarAmount;

        $piutang->bayar = $newBayarTotal;

        if ($newBayarTotal >= $piutang->total) {
            $piutang->status = 'cash';
        }

        $piutang->save();

        $newPiutang = new Piutang;
        $newPiutang->jual_id = $piutang->id;
        $newPiutang->pembayaran = $bayarAmount;
        $newPiutang->tanggal = $request->input('date');
        $newPiutang->keterangan = $piutang->status;
        $newPiutang->save();

        return response()->json([
            'success' => true,
            'message' => 'Pembayaran berhasil dilakukan',
            'status' => $piutang->status,
        ]);
    }

    public function destroy(string $id) {}
}
