@extends('layouts.template')
@section('css')
    <style>
        input[type=number]::-webkit-outer-spin-button,
        input[type=number]::-webkit-inner-spin-button {
            -webkit-appearance: none;
        }
    </style>
@endsection
@section('content')
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Jurnal Piutang</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item active">Menu/Jurnal Piutang</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-md-6 col-12">
                                <h4 class="card-title">Piutang</h4>
                                <p class="card-title-desc">Kelola Jurnal Piutang</p>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="table" class="table table-bordered dt-responsive  nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>No Faktur</th>
                                        <th>Nama</th>
                                        <th>Tanggal</th>
                                        <th>Total</th>
                                        <th>Bayar</th>
                                        <th>Diskon</th>
                                        <th>ppn</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
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

        <div id="myModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">Lakukan Pembayaran </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <form id="form-bayar" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama</label>
                                <input type="text" class="form-control" id="nama" name="nama" readonly>
                                <div class="alert alert-danger mt-2 d-none"></div>
                            </div>

                            <div class="mb-3">
                                <label for="Total-bayar" class="form-label">Total Bayar</label>
                                <input type="text" class="form-control" id="Total-bayar" name="Total-bayar" readonly>
                                <div class="alert alert-danger mt-2 d-none"></div>
                            </div>

                            <div class="col-lg-5">
                                <label for="bayar" class="form-label">Bayar</label>
                                <input type="number" class="form-control" id="bayar" name="bayar"
                                    placeholder="Masukan Nominal">
                                <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-bayar"></div>
                            </div>
                        </form>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-primary waves-effect waves-light"
                            id="store">Konfirmasi</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $('#table').DataTable({
                "responsive": true,
                "serverSide": true,
                "processing": true,
                "ajax": {
                    "url": "{{ route('menu.jurnal-piutang.index') }}",
                    "type": "GET"
                },
                "columns": [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',pok
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'no_faktur',
                        name: 'no_faktur'
                    },
                    {
                        data: 'customer_nama',
                        name: 'customer_nama'
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
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },
                ]
            });
        });


        $('body').on('click', '#btn-bayar', function() {
            $('#myModal').modal('show');
            var id = $(this).data('id');
            $.ajax({
                url: `/menu/jurnal-piutang/${id}`,
                method: 'GET',
                cache: false,
                success: function(response) {
                    $('#nama').val(response.data.customer.nama);
                    $('#Total-bayar').val(response.data.total);
                    $('#myModal').modal('show');

                }
            });
        });
    </script>
@endsection
