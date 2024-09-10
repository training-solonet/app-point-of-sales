<?php

namespace App\Http\Controllers;

use App\Models\Jurnal_harian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JurnalHarianController extends Controller
{
    public function index(Request $request)
    {
        $jurnal = Jurnal_harian::query();

        // Filter berdasarkan rentang tanggal
        if ($request->has('start') && $request->has('end')) {
            $startDate = $request->input('start');
            $endDate = $request->input('end');

            if (!empty($startDate) && !empty($endDate)) {
                $jurnal->whereBetween('tanggal', [$startDate, $endDate]);
            }
        }

        // Filter tambahan yang ditangani melalui AJAX request
        if ($request->ajax()) {
            // Cek apakah filter diterapkan
            if ($request->has('filter')) {
                $filter = $request->get('filter');

                switch ($filter) {
                    case 'kredit':
                        // Filter jurnal dengan kredit > 0
                        $jurnal->where('kredit', '>', 0);
                        break;
                    case 'debit':
                        // Filter jurnal dengan debit > 0
                        $jurnal->where('debit', '>', 0);
                        break;
                    case 'bank':
                        // Filter jurnal dengan status bank
                        $jurnal->where('status', 'bank');
                        break;
                    case 'cash':
                        // Filter jurnal dengan status cash
                        $jurnal->where('status', 'cash');
                        break;
                    default:
                        // Default sorting jika tidak ada filter yang dipilih
                        $jurnal->orderBy('id', 'asc');
                        break;
                }
            }

            // Eksekusi query dan kirim hasil melalui DataTables
            return datatables()->of($jurnal->get())
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $button = '<a href="javascript:void(0)" id="btn-edit" data-id="' . $data->id . '" class="btn btn-warning btn-sm">Edit</a>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<a href="javascript:void(0)" id="btn-delete" data-id="' . $data->id . '" class="btn btn-danger btn-sm">Delete</a>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        // Kembalikan view dengan data jurnal jika bukan AJAX request
        return view('menu.jurnal-harian.index');
    }

    public function create()
    {
        $saldo = Jurnal_harian::where('status', 'cash')->sum('debit') - Jurnal_harian::where('status', 'cash')->sum('kredit');

        return response()->json([
            'success' => true,
            'saldo' => number_format($saldo),
        ]);

    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tanggal' => 'required',
            'jenis' => 'required|in:Pemasukan,Pengeluaran',
            'nominal' => 'required',
            'keterangan' => 'required|string',
            'status' => 'required|in:cash,bank',
            'debit' => 'required|numeric',
            'kredit' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $debit = $request->input('jenis') === 'Pemasukan' ? $request->input('nominal') : 0;
        $kredit = $request->input('jenis') === 'Pengeluaran' ? $request->input('nominal') : 0;

        $data = [
            'tanggal' => $request->input('tanggal'),
            'keterangan' => $request->input('keterangan'),
            'debit' => $debit,
            'kredit' => $kredit,
            'status' => $request->input('status'),
        ];

        Jurnal_harian::create($data);

        return response()->json(['success' => true, 'message' => 'Data berhasil disimpan.']);
    }

    public function show($id)
    {
        $jurnal = Jurnal_harian::find($id);

        $nominal = $jurnal->debit ? $jurnal->debit : $jurnal->kredit;

        return response()->json([
            'data' => [
                'id' => $jurnal->id,
                'tanggal' => $jurnal->tanggal,
                'keterangan' => $jurnal->keterangan,
                'debit' => $jurnal->debit,
                'kredit' => $jurnal->kredit,
                'jenis' => $jurnal->debit ? 'Pemasukan' : 'Pengeluaran',
                'nominal' => $nominal,
                'status' => $jurnal->status,
            ],
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'tanggal' => 'required',
            'jenis' => 'required|in:Pemasukan,Pengeluaran',
            'nominal' => 'required',
            'keterangan' => 'required|string',
            'status' => 'required|in:cash,bank',
            'debit' => 'required|numeric',
            'kredit' => 'required|numeric',

        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $jurnal = Jurnal_harian::find($id);

        $jurnal->update([

            'tanggal' => $request->input('tanggal'),
            'jenis' => $request->input('jenis'),
            'nominal' => $request->input('nominal'),
            'keterangan' => $request->input('keterangan'),
            'status' => $request->input('status'),
            'debit' => $request->input('debit'),
            'kredit' => $request->input('kredit'),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Diupdate!',
            'data' => $jurnal,
        ]);
    }

    public function destroy($id, Request $request)
    {
        Jurnal_harian::find($id)->delete();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil dihapus!',
            ]);
        }
    }
}
