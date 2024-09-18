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

        if ($request->has('start') && $request->has('end')) {
            $startDate = $request->input('start');
            $endDate = $request->input('end');

            if (! empty($startDate) && ! empty($endDate)) {
                $jurnal->whereBetween('tanggal', [$startDate, $endDate]);
            }
        }

        if ($request->ajax()) {
            if ($request->has('filter')) {
                $filter = $request->get('filter');

                switch ($filter) {
                    case 'kredit':
                        $jurnal->where('kredit', '>', 0);
                        break;
                    case 'debit':
                        $jurnal->where('debit', '>', 0);
                        break;
                    case 'bank':
                        $jurnal->where('status', 'bank');
                        break;
                    case 'cash':
                        $jurnal->where('status', 'cash');
                        break;
                    default:
                        $jurnal->orderBy('id', 'asc');
                        break;
                }
            }

            return datatables()->of($jurnal->get())
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $button = '<a href="javascript:void(0)" id="btn-edit" data-id="'.$data->id.'" class="btn btn-warning btn-sm">Edit</a>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<a href="javascript:void(0)" id="btn-delete" data-id="'.$data->id.'" class="btn btn-danger btn-sm">Delete</a>';

                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

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
        $saldo = Jurnal_harian::where('status', 'cash')->sum('debit') - Jurnal_harian::where('status', 'cash')->sum('kredit');

        $validator = Validator::make($request->all(), [
            'tanggal' => 'required',
            'jenis' => 'required|in:Pemasukan,Pengeluaran',
            'nominal' => 'required',
            'keterangan' => 'required|string',
            'status' => 'required|in:cash,bank',
            'debit' => 'required|numeric',
            'kredit' => 'required|numeric',
        ]);

        $validator->after(function ($validator) use ($request, $saldo) {
            if ($request->jenis === 'Pengeluaran' && $request->nominal > $saldo) {
                $validator->errors()->add('nominal', 'Pengeluaran melebihi saldo yang tersedia!');
            }
        });

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
        $saldo = Jurnal_harian::where('status', 'cash')->sum('debit') - Jurnal_harian::where('status', 'cash')->sum('kredit');

        $validator = Validator::make($request->all(), [
            'tanggal' => 'required',
            'jenis' => 'required|in:Pemasukan,Pengeluaran',
            'nominal' => 'required',
            'keterangan' => 'required|string',
            'status' => 'required|in:cash,bank',
            'debit' => 'required|numeric',
            'kredit' => 'required|numeric',

        ]);

        $validator->after(function ($validator) use ($request, $saldo) {
            if ($request->jenis === 'Pengeluaran' && $request->nominal > $saldo) {
                $validator->errors()->add('nominal', 'Pengeluaran melebihi saldo yang tersedia!');
            }
        });
        
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
