@extends('layouts.template')
@section('css')
@endsection
@section('content')
<div class="container-fluid">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Jurnal Harian</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">Menu/Jurnal Harian</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-md-12 col-12">
                            <h4 class="card-title">Data Jurnal Harian</h4>
                            <p class="card-title-desc">Anda dapat mengelola cash flow harian dihalaman ini.</p>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <p>Tampilkan data dari table pembelian & detail_pembalian, join dengan purchase order dan join dengan distributor</p>
                        <table id="table" class="table table-bordered dt-responsive  nowrap w-100">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tanggal</th>
                                    <th>Keterangan</th>
                                    <th>Debit</th>
                                    <th>Kredit</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>12/08/2024</td>
                                    <td>Beli Bensin</td>
                                    <td>0</td>
                                    <td>100.000</td>
                                    <td>Cash</td>
                                    <td>
                                        CRUD
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


</div>
</div>
</div>
@endsection
@section('js')

@endsection