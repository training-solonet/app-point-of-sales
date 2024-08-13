@extends('layouts.template')
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet" type="text/css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" rel="stylesheet" />

    <style>
        input[type=number]::-webkit-outer-spin-button,
        input[type=number]::-webkit-inner-spin-button {
            -webkit-appearance: none;
        }

        .text-right {
            text-align: right;
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
                        <form>
                            <div class="mb-3">
                                <label class="form-label">Multiple Select</label>
                                <select class="select2 form-control select2-mu  ltiple" multiple="multiple"
                                    data-placeholder="Masukkan Customer">
                                    @foreach ($customer as $c)
                                        <option>{{ $c->nama }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-4">
                                <label>Date Range</label>
                                <div class="input-daterange input-group" id="datepicker6" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
                                    <input type="text" class="form-control" name="start" placeholder="Start Date" />
                                    <input type="text" class="form-control" name="end" placeholder="End Date" />
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">With prefix </label>
                                <input data-toggle="touchspin" type="text" data-bts-prefix="$">
                            </div>
                        </form>
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
                            <input type="hidden" id="id" name="id">
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama</label>
                                <input type="text" class="form-control" id="nama" name="nama" disabled>
                                <div class="alert alert-danger mt-2 d-none"></div>
                            </div>

                            <div class="mb-3">
                                <label for="Total-bayar" class="form-label">Total Bayar</label>
                                <input type="text" class="form-control" id="Total-bayar" name="Total-bayar" disabled>
                                <div class="alert alert-danger mt-2 d-none"></div>
                            </div>

                            <div class="mb-3">
                                <label for="belum-dibayar" class="form-label">Yang Belum Dibayar</label>
                                <input type="text" class="form-control" id="belum-dibayar" name="belum-dibayar" disabled>
                                <div class="alert alert-danger mt-2 d-none"></div>
                            </div>

                            <div class="row">
                                <div class="col-lg-5">
                                    <label for="date" class="form-label">Tanggal Pembayaran</label>
                                    <input class="form-control" type="date" id="date">
                                </div>

                                <div class="col-lg-5">
                                    <label for="bayar" class="form-label">Bayar</label>
                                    <input type="number" class="form-control text-right" id="bayar" name="bayar"
                                        placeholder="Masukan Nominal">
                                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-bayar"></div>
                                </div>

                            </div>

                        </form>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary waves-effect"
                            data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-primary waves-effect waves-light"
                            id="update">Konfirmasi</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>


    <script>
        function formatNumber(number) {
            return Number(number).toLocaleString('id-ID');
        }

        function setDateToday() {
            var today = new Date().toISOString().split('T')[0];
            document.getElementById('date').value = today;
        }

        function formatDate(date) {
            var parts = date.split('-');
            return parts[2] + '-' + parts[1] + '-' + parts[0];
        }

        $(document).ready(function() {
            $('.select2').select2()
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
                        render: function(data) {
                            return formatDate(data);
                        }
                    },
                    {
                        data: 'total',
                        name: 'total',
                        className: "text-right",
                        render: function(data) {
                            return formatNumber(data);
                        }
                    },
                    {
                        data: 'bayar',
                        name: 'bayar',
                        className: "text-right",
                        render: function(data) {
                            return formatNumber(data);
                        }
                    },
                    {
                        data: 'diskon',
                        name: 'diskon',
                        className: "text-right",
                        render: function(data) {
                            return formatNumber(data);
                        }
                    },
                    {
                        data: 'ppn',
                        name: 'ppn',
                        className: "text-right",
                        render: function(data) {
                            return formatNumber(data);
                        }
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    }
                ]
            });

            $('#datepicker6').datepicker({
                format: 'dd-mm-yyyy',
                autoclose: true,
                todayHighlight: true,
                orientation: "top"
            });


            $('body').on('click', '#btn-bayar', function() {
                var id = $(this).data('id');

                $.ajax({
                    url: `/menu/jurnal-piutang/${id}`,
                    method: 'GET',
                    cache: false,
                    success: function(response) {
                        $('#myModal #id').val(response.data.id);
                        $('#myModal #nama').val(response.data.customer.nama);
                        $('#myModal #Total-bayar').val(response.data.total);
                        $('#myModal #belum-dibayar').val(response.belum_dibayar);
                        setDateToday();
                        $('#update').data('id', id);
                        $('#myModal').modal('show');
                    }
                });
            });

            $('#bayar').on('input', function() {
                if ($(this).val() !== '') {
                    $('#alert-bayar').removeClass('d-block').addClass('d-none');
                }
            });

            $('#update').on('click', function() {
                var id = $(this).data('id');
                var bayar = $('#bayar').val();
                var date = $('#date').val();

                if (bayar === '') {
                    $('#alert-bayar').removeClass('d-none').addClass('d-block').html('bayar required.');
                    return;
                }

                $.ajax({
                    url: `/menu/jurnal-piutang/${id}`,
                    method: 'PUT',
                    data: {
                        _token: "{{ csrf_token() }}",
                        bayar: bayar,
                        date: date
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#myModal').modal('hide');
                            $('#table').DataTable().ajax.reload();
                            $('#myModal form')[0].reset();

                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'success',
                                title: response.message,
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                            });
                        } else {
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'error',
                                title: response.message,
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                            });
                        }
                    },
                });
            });
        });
    </script>
@endsection
