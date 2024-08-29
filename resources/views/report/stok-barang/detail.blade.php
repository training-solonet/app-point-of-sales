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
                                        <th>Tanggal Masuk</th>
                                        <th>Harga Beli</th>
                                        <th>Distributor</th>
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
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $('#detailTable').DataTable({
                responsive: true,
                serverSide: true,
                processing: true,
                ajax: {
                    url: '/report/stok-barang/{{ $id }}',
                    type: 'GET'
                },
                'columns': [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'tanggal_masuk',
                        name: 'tanggal_masuk',
                        render: function(data, type, row) {
                            if (data) {
                                var date = new Date(data);
                                var day = ('0' + date.getDate()).slice(-2);
                                var month = ('0' + (date.getMonth() + 1)).slice(-2);
                                var year = date.getFullYear().toString();
                                return `${day}/${month}/${year}`;
                            }
                            return '';
                        }
                    },
                    {
                        data: 'harga_beli',
                        name: 'harga_beli',
                        render: $.fn.dataTable.render.number('.', ',', 0, 'Rp ')
                    },
                    {
                        data: 'distributor',
                        name: 'distributor'
                    }
                ]
            });
        });
    </script>
@endsection
