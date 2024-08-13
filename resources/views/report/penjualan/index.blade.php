@extends('layouts.template')
@section('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="{{ asset('assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet"
    type="text/css">
<link href="{{ asset('assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css') }}" rel="stylesheet"
    type="text/css" />
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
                            <p class="card-title-desc">Data seluruh penjualan yang tercatat</p>
                        </div>
                    </div>
                    <div class="table-responsive">
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
                    <form class="mt-5">
                        <div class="mb-3">
                            <label class="form-label">Filter nama (multiple)</label>
                            <select class="select2 form-control select2-multiple" name="filter_customer"
                                multiple="multiple" data-placeholder="Pilih Nama">
                                @foreach ($customer as $c)
                                    <option value="{{ $c->id}}">{{$c->nama}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label>Filter Tanggal</label>
                            <div class="input-daterange input-group" id="datepicker6" data-date-format="dd M, yyyy"
                                data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
                                <input type="text" class="form-control" name="start" placeholder="Start Date" />
                                <input type="text" class="form-control" name="end" placeholder="End Date" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">Min </label>
                                    <input data-toggle="touchspin" type="text" data-bts-prefix="Rp">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">Max </label>
                                    <input data-toggle="touchspin" type="text" data-bts-prefix="Rp">
                                </div>
                            </div>
                        </div>
                    </form>
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
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="{{ asset('assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js') }}"></script>
<script>
    $(document).ready(function () {
        setTimeout(function () {
            $('.alert').fadeOut('slow');
        }, 1000);

        $('.select2').select2();

        $('#datepicker6').datepicker({
            format: 'dd M, yyyy',
            autoclose: true,
            todayHighlight: true,
            orientation: 'top auto'
        });

        function formatCurrency(value) {
            return parseInt(value).toLocaleString('id-ID').replace(/,/g, '.');
        }

        $("input[data-toggle='touchspin']").TouchSpin({
            max: 100000000,
            step: 1000,
            decimals: 2,
            forcestepdivisibility: 'none',
            prefix: 'Rp',
            initval: 0,
        }).on('touchspin.on.startupspin touchspin.on.startdownspin touchspin.on.min touchspin.on.max', function () {
            var value = $(this).val().replace(/Rp/g, '').replace(/\./g, '').trim();
            $(this).val(formatCurrency(value));
        });

        // Initialize datatable with filter
        var table = $('#table').DataTable({
            'responsive': true,
            'serverSide': true,
            'processing': true,
            'ajax': {
                'url': "{{ route('report.penjualan.index') }}",
                'type': 'GET',
                'data': function (d) {
                    d.filter_customer = $('select[name="filter_customer"]').val();
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
                name: 'tanggal',
                render: function (data, type, row) {
                    if (data) {
                        var date = new Date(data);
                        var day = ('0' + date.getDate()).slice(-2);
                        var month = ('0' + (date.getMonth() + 1)).slice(-2);
                        var year = date.getFullYear().toString().slice(-2);
                        return `${day}/${month}/${year}`;
                    }
                    return '';
                },
            },
            {
                data: 'total',
                name: 'total',
                render: function (data, type, row) {
                    return formatCurrency(data);
                },
                className: 'text-end'
            },
            {
                data: 'bayar',
                name: 'bayar',
                render: function (data, type, row) {
                    return formatCurrency(data);
                },
                className: 'text-end'
            },
            {
                data: 'diskon',
                name: 'diskon',
                render: function (data, type, row) {
                    return formatCurrency(data);
                },
                className: 'text-end'
            },
            {
                data: 'ppn',
                name: 'ppn',
                render: function (data, type, row) {
                    return formatCurrency(data);
                },
                className: 'text-end'
            },
            {
                data: 'status',
                name: 'status',
                className: 'text-center'
            }
            ]
        });

        $('select[name="filter_customer"], input[name="start"], input[name="end"], input[name="min"], input[name="max"]').on('change', function () {
            table.ajax.reload();
        });
    });

</script>


@endsection