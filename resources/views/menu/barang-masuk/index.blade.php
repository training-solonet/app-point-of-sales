@extends('layouts.template')
@section('css')
@endsection
@section('content')
<div class="container-fluid">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Barang Masuk</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">Menu/Barang Masuk</li>
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
                            <h4 class="card-title">Daftar Barang Masuk</h4>
                            <p class="card-title-desc">Anda dapat mengelola data barang masuk untuk menambah stok
                                dihalaman ini.</p>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <p>Tampilkan data dari table pembelian & detail_pembalian, join dengan purchase order dan join
                            dengan distributor</p>
                        <table id="table" class="table table-bordered dt-responsive  nowrap w-100">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tanggal Beli</th>
                                    <th>Invoice</th>
                                    <th>Distributor</th>
                                    <th>Total Barang</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- <tr>
                                    <td>1</td>
                                    <td>12/08/2024</td>
                                    <td>INV001</td>
                                    <td>Metro Data</td>
                                    <td>5 Barang</td>
                                    <td>
                                        <a href="/menu/barang-masuk/1" class="btn btn-info waves-effect waves-light">Detail</button>
                                    </td>
                                </tr> -->
                            </tbody>
                        </table>
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
        $('#table').DataTable({
            'responsive': true,
            'serverSide': true,
            'processing': true,
            'ajax': {
                'url': "{{ route('menu.barang-masuk.index') }}",
                'type': 'GET'
            },
            'columns': [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            },
            {
                data: 'tgl_beli',
                name: 'tgl_beli'
            },
            {
                data: 'no_invoice',
                name: 'no_invoice',
            },
            {
                data: 'purchase_orders.distributor.nama',
                name: 'purchase_orders.distributor.nama',
            },
            {
                data: 'total_barang',
                name: 'total_barang',
            },
            {
                data: 'action',
                name: 'action'
            }
            ]
        });


    });
</script>
@endsection