@extends('layouts.template')
@section('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="{{ asset('assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css">
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
                <h4 class="mb-sm-0 font-size-18">Piutang</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">Report/Piutang</li>
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
                            <h4 class="card-title">Data Pembayaran Piutang</h4>
                            <p class="card-title-desc">Data Piutang yang sudah lunas</p>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <div class="btn-group mb-3">
                            <button type="button" class="btn dropdown-toggle border border-black" data-bs-toggle="dropdown" aria-expanded="false"><i class="bx bx-filter-alt"></i></button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="#">Default</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-filter="no_faktur">No Faktur</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item disabled" href="#" aria-disabled="true"><i class="bx bx-calendar-alt"></i> Tanggal</a>
                                <a class="dropdown-item" href="#" data-filter="tanggal_terbaru">Baru</a>
                                <a class="dropdown-item" href="#" data-filter="tanggal_terlama">Lama</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item disabled" href="#" aria-disabled="true"><i class="bx bx-calculator"></i> Pembayaran</a>
                                <a class="dropdown-item" href="#" data-filter="pembayaran_terbesar">Besar</a>
                                <a class="dropdown-item" href="#" data-filter="pembayaran_terkecil">Kecil</a>
                            </div>
                        </div>
                        <input type="hidden" id="filter" value="default">
                        <form class="mt-3 mb-5">
                            <div class="mb-4">
                                <label>Filter Tanggal</label>
                                <div class="input-daterange input-group" id="datepicker6" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
                                    <input type="text" class="form-control" name="start" placeholder="Start Date" />
                                    <input type="text" class="form-control" name="end" placeholder="End Date" />
                                </div>
                            </div>
                            <button type="button" class="btn btn-secondary waves-effect waves-light align-middle me-2" id="btn-reset"><i class="bx bx-reset"></i> Reset Filter</button>
                        </form>
                        <table id="table" class="table table-bordered dt-responsive  nowrap w-100">
                            <thead>
                                <tr>
                                    <th># </th>
                                    <th>ID Jual</th>
                                    <th>Tanggal</th>
                                    <th>Pembayaran</th>
                                    <th>Keterangan</th>
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
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="{{ asset('assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script>
    $(document).ready(function() {
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 1000);

        $('.select2').select2();

        $('#datepicker6').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
            orientation: 'auto'
        });

        // Initialize datatable with filter
        var table = $('#table').DataTable({
            'responsive': true,
            'serverSide': true,
            'processing': true,
            'ajax': {
                'url': "{{ route('report.pembayaran-piutang.index') }}",
                'type': 'GET',
                'data': function(d) {
                    d.filter = $('#filter').val();
                    d.filter_customer = $('select[name="filter_customer"]').val();
                    d.start = $('input[name="start"]').val();
                    d.end = $('input[name="end"]').val();
                }
            },
            'columns': [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'jual.no_faktur',
                    name: 'jual.no_faktur',
                    // render: function (data, type, row) {
                    //     var url = "{{ route('report.pembayaran-piutang.index') }}".replace(':id', row.id);
                    //     return '<a href="' + url + '">' + data + '</a>';
                    // }
                },
                {
                    data: 'tanggal',
                    name: 'tanggal',
                    render: function(data, type, row) {
                        if (data) {
                            var date = new Date(data);
                            var day = ('0' + date.getDate()).slice(-2);
                            var month = ('0' + (date.getMonth() + 1)).slice(-2);
                            var year = date.getFullYear().toString();
                            return `${day}/${month}/${year}`;
                        }
                        return '';
                    },
                },
                {
                    data: 'pembayaran',
                    name: 'pembayaran',
                    render: $.fn.dataTable.render.number(',', '.', 0, 'Rp ')
                },
                {
                    data: 'keterangan',
                    name: 'keterangan',
                    className: 'text-center'
                },
            ]
        });

        $('.dropdown-menu a').on('click', function() {
            var filterValue = $(this).data('filter');
            $('#filter').val(filterValue);
            table.ajax.reload();
        });

        $('select[name="filter_customer"], input[name="start"], input[name="end"], input[name="min"], input[name="max"]').on('change', function() {
            table.ajax.reload();
        });

        $('#btn-reset').on('click', function() {
            $('select[name="filter_customer"]').val(null).trigger('change');
            $('input[name="start"]').val('');
            $('input[name="end"]').val('');
            $('#filter').val('default');
            table.ajax.reload();

        });
    });
</script>


@endsection