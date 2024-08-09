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
                                <input type="number" class="form-control" id="bayar" name="bayar"
                                    placeholder="Masukan Nominal">
                            </div>

                        </div>

                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary waves-effect waves-light"
                        id="update">Konfirmasi</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    $(document).ready(function () {
        // Initialize DataTable
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
            }
            ]
        });

        // Set today's date in the date input
        function setDateToday() {
            var today = new Date().toISOString().split('T')[0];
            document.getElementById('date').value = today;
        }

        // Handle the click event on the "Pay" button
        $('body').on('click', '#btn-bayar', function () {
            var id = $(this).data('id');

            $.ajax({
                url: `/menu/jurnal-piutang/${id}`,
                method: 'GET',
                cache: false,
                success: function (response) {
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

        // Handle the "Confirm" button click
        $('#update').on('click', function () {
            var id = $(this).data('id');
            var bayar = $('#bayar').val();
            var date = $('#date').val();

            $.ajax({
                url: `/menu/jurnal-piutang/${id}`,
                method: 'PUT',
                data: {
                    _token: "{{ csrf_token() }}",
                    bayar: bayar,
                    date: date
                },
                success: function (response) {
                    if (response.success) {
                        $('#myModal').modal('hide');
                        $('#table').DataTable().ajax.reload();

                        // Optionally, display a success message
                        alert('Pembayaran berhasil! Status: ' + response.status);
                    } else {
                        alert(response.message);
                    }
                },
                error: function (response) {
                    alert('Error: ' + response.responseJSON.message);
                }
            });
        });
    });
</script>
@endsection