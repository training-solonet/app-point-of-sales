@extends('layouts.template')

@section('content')
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Detail Stok Barang</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Detail Stok</h4>
                        <p class="card-title-desc">Detail stok barang dengan ID: {{ $id }}</p>

                        <div class="table-responsive">
                            <table id="detailTable" class="table table-bordered dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Barang</th>
                                        <th>Qty</th>
                                        <th>Harga Satuan</th>
                                        <th>Total Harga</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <th>hahay</th>
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
        $(document).ready(function() {
            $('#detailTable').DataTable({
                'responsive': true,
                'serverSide': true,
                'processing': true,
                'ajax': {
                    'url': "{{ url('/report/stok-barang/' . $id) }}",
                    'type': 'GET'
                },
                'columns': [
                    {
                        data: 'index',
                        name: 'index'
                    },
                    {
                        data: 'nama_barang',
                        name: 'nama_barang'
                    },
                    {
                        data: 'qty',
                        name: 'qty'
                    },
                    {
                        data: 'harga_satuan',
                        name: 'harga_satuan',
                        render: $.fn.dataTable.render.number('.', ',', 0, 'Rp ')
                    },
                    {
                        data: 'total_harga',
                        name: 'total_harga',
                        render: $.fn.dataTable.render.number('.', ',', 0, 'Rp ')
                    }
                ]
            });
        });
    </script>
@endsection
