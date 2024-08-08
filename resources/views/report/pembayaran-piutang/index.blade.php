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
                        <table id="table" class="table table-bordered dt-responsive  nowrap w-100">
                            <thead>
                                <tr>
                                    <th># </th>
                                    <th>ID Jual</th>
                                    <th>Pembayaran</th>
                                    <th>Tanggal</th>
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
                'url': "{{ route('report.pembayaran-piutang.index') }}",
                'type': 'GET',
            },
            'columns': [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            },
            {
                data: 'jual.no_faktur',
                name: 'jual.no_faktur'
            },
            {
                data: 'pembayaran',
                name: 'pembayaran'
            },
            {
                data: 'tanggal',
                name: 'tanggal'
            },
            {
                data: 'keterangan', 
                name: 'keterangan'
            },
            ]
        });

    });
</script>


@endsection