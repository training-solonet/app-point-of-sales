@extends('layouts.template')
@section('css')
@endsection
@section('content')
<style>
    .dropdown-menu {
        max-height: 300px;
        overflow-y: scroll;
    }
</style>
<div class="container-fluid">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Penjualan</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">Report/Penjualan</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <div class="card">
                <div class="card-body">
                    <div class="row ">
                        <div class="col-md-6 col-12">
                            <h4 class="card-title">Data Penjualan</h4>
                            <p class="card-title-desc">Data seluruh penjualan</p>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <div class="btn-group mb-3">
                            <button type="button" class="btn dropdown-toggle border border-black" data-bs-toggle="dropdown"
                                aria-expanded="false"><i class="bx bx-filter-alt"></i></button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="#">Default</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-filter="no_faktur">No Faktur</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-filter="nama_customer">Nama Customer</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item disabled" href="#" aria-disabled="true"><i
                                        class="bx bx-calendar-alt"></i> Tanggal</a>
                                <a class="dropdown-item" href="#" data-filter="tanggal_terbaru">Tanggal Terbaru</a>
                                <a class="dropdown-item" href="#">Tanggal Terlama</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item disabled" href="#" aria-disabled="true"><i
                                        class="bx bx-calculator"></i> Total Pembelian</a>
                                <a class="dropdown-item" href="#" data-filter="total_terbesar">Total Terbesar</a>
                                <a class="dropdown-item" href="#" data-filter="total_terkecil">Total Terkecil</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item disabled" href="#" aria-disabled="true"><i
                                        class="bx bx-money"></i> Sudah Bayar/Belum Bayar</a>
                                <a class="dropdown-item" href="#" data-filter="sudah_terbayar">Terbayar</a>
                                <a class="dropdown-item" href="#" data-filter="belum_terbayar">Belum Terbayar</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item disabled" href="#" aria-disabled="true"><i
                                        class="bx bxs-bank"></i> Jenis Pembayaran</a>
                                <a class="dropdown-item" href="#" data-filter="bank">Bank</a>
                                <a class="dropdown-item" href="#" data-filter="cash">Cash</a>
                                <a class="dropdown-item" href="#" data-filter="piutang">Piutang</a>
                            </div>
                        </div><!-- /btn-group -->
                        <input type="hidden" id="filter" value="default">
                        <table id="table" class="table table-bordered dt-responsive  nowrap w-100">
                            <thead>
                                <tr>
                                    <th># </th>
                                    <th>No Faktur</th>
                                    <th>Customer</th>
                                    <th>Tanggal Pembelian</th>
                                    <th>Total</th>
                                    <th>Bayar</th>
                                    <th>Diskon</th>
                                    <th>PPN</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>

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
<script>
    $(document).ready(function () {
        setTimeout(function () {
            $('.alert').fadeOut('slow');
        }, 1000);

        // Initialize datatable with filter
        var table = $('#table').DataTable({
            'responsive': true,
            'serverSide': true,
            'processing': true,
            'ajax': {
                'url': "{{ route('report.penjualan.index') }}",
                'type': 'GET',
                'data': function (d) {
                    d.filter = $('#filter').val();
                }
            },
            'columns': [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            },
            {
                data: 'no_faktur',
                name: 'no_faktur'
            },
            {
                data: 'customer.nama',
                name: 'customer.nama'
            },
            {
                data: 'tanggal',
                name: 'tanggal'
            },
            {
                data: 'total',
                name: 'total'
            },
            {
                data: 'bayar',
                name: 'bayar'
            },
            {
                data: 'diskon',
                name: 'diskon'
            },
            {
                data: 'ppn',
                name: 'ppn'
            },
            {
                data: 'status',
                name: 'status'
            }
            ]
        });

        // Handle filter change
        $('.dropdown-menu a').on('click', function () {
            var filterValue = $(this).data('filter');
            $('#filter').val(filterValue);
            table.ajax.reload();
        });
    });
</script>


@endsection