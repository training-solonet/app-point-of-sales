@extends('layouts.template')
@section('css')
    <style>
        input[type=number]::-webkit-outer-spin-button,
        input[type=number]::-webkit-inner-spin-button {
            -webkit-appearance: none;
        }

        input[type=number] {
            -moz-appearance: textfield;
        }
    </style>
@endsection
@section('content')
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Customer</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item active">Master/Customer</li>
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
                            <div class="col-md-6 col-12">
                                <h4 class="card-title">Data Customer</h4>
                                <p class="card-title-desc">Kelola semua data costumer disini.</p>
                            </div>
                            <div class="col-md-6">
                                <button type="button" class="btn btn-primary waves-effect waves-light float-md-end"
                                    data-bs-toggle="modal" data-bs-target="#myModal" id="btn-create-post">
                                    <i class="fas fa-plus"></i> Tambah Costumer</button>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table id="table" class="table table-bordered dt-responsive  nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama</th>
                                        <th>Alamat</th>
                                        <th>No Hp</th>
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

        <!-- Modal Create -->
        <div id="myModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">Tambahkan Customer</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <form action="/master/customer" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama</label>
                                <input type="text" class="form-control" id="nama" name="nama"
                                    placeholder="Enter Your Name">
                                <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-nama"></div>
                            </div>

                            <div class="mb-3">
                                <label for="alamat" class="form-label">Alamat</label>
                                <input type="text" class="form-control" id="alamat" name="alamat"
                                    placeholder="Enter Your Adress">
                                <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-alamat"></div>
                            </div>

                            <div class="mb-3">
                                <label for="number" class="form-label">No HP</label>
                                <input type="number" class="form-control" id="no_hp" name="no_hp"
                                    placeholder="Enter Your Number">
                                <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-no_hp"></div>
                            </div>

                            <div class="modal-footer">
                                <button type="button"
                                    class="btn btn-secondary waves-effect"data-bs-dismiss="modal">Tutup</button>
                                <button type="button" class="btn btn-primary waves-effect waves-light"
                                    id="store">Simpan Data</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Edit -->
        <div id="modal-edit" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">Update Customer</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <form id="form-edit" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" id="id">
                            <div class="mb-3">
                                <label for="nama-edit" class="form-label">Nama</label>
                                <input type="text" class="form-control" id="nama-edit" name="nama"
                                    placeholder="Enter Name">
                                <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-nama-edit"></div>
                            </div>
                            <div class="mb-3">
                                <label for="alamat-edit" class="form-label">Alamat</label>
                                <input type="text" class="form-control" id="alamat-edit" name="alamat"
                                    placeholder="Enter information">
                                <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-alamat-edit">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="no_hp-edit" class="form-label">No Hp</label>
                                <input type="text" class="form-control" id="no_hp-edit" name="no_hp"
                                    placeholder="Enter information">
                                <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-no_hp-edit">
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary waves-effect"
                            data-bs-dismiss="modal">Tutup</button>
                        <button type="button" class="btn btn-primary waves-effect waves-light" id="update">Simpan
                            Data</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });

        // tampil data
        $(document).ready(function() {
            $('#table').DataTable({
                "responsive": true,
                "serverSide": true,
                "processing": true,
                "ajax": {
                    "url": "{{ route('master.customer.index') }}",
                    "type": "GET"
                },
                "columns": [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'alamat',
                        name: 'alamat'
                    },
                    {
                        data: 'no_hp',
                        name: 'no_hp'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    }
                ]
            });
        });

        // create data
        $('body').on('click', '#btn-create-post', function() {
            $('#myModal').modal('show');
        });

        $('#store').click(function(e) {
            e.preventDefault();

            let nama = $('#nama').val();
            let alamat = $('#alamat').val();
            let no_hp = $('#no_hp').val();
            let token = $("meta[name='csrf-token']").attr("content");

            $.ajax({
                url: `/master/customer`,
                type: "POST",
                cache: false,
                data: {
                    "nama": nama,
                    "alamat": alamat,
                    "no_hp": no_hp,
                    "_token": token
                },
                success: function(response) {
                    if (response.success) {
                        Toast.fire({
                            title: response.message
                        });

                        $('#table').DataTable().ajax.reload();

                        $('#nama').val('');
                        $('#alamat').val('');
                        $('#no_hp').val('');

                        $('#myModal').modal('hide');
                    } else {
                        Toast.fire({
                            title: response.message
                        });
                    }
                },
                error: function(error) {
                    if (error.responseJSON.nama) {
                        $('#alert-nama').removeClass('d-none');
                        $('#alert-nama').addClass('d-block');
                        $('#alert-nama').html(error.responseJSON.nama[0]);
                    }

                    if (error.responseJSON.alamat) {
                        $('#alert-alamat').removeClass('d-none');
                        $('#alert-alamat').addClass('d-block');
                        $('#alert-alamat').html(error.responseJSON.alamat[0]);
                    }

                    if (error.responseJSON.no_hp) {
                        $('#alert-no_hp').removeClass('d-none');
                        $('#alert-no_hp').addClass('d-block');
                        $('#alert-no_hp').html(error.responseJSON.no_hp[0]);
                    }
                }
            });
        });

        // Edit data
        $('body').on('click', '#btn-edit-post', function() {
            let id = $(this).data('id');
            $.ajax({
                url: `/master/customer/${id}`,
                type: "GET",
                cache: false,
                success: function(response) {
                    $('#id').val(response.data.id);
                    $('#nama-edit').val(response.data.nama);
                    $('#alamat-edit').val(response.data.alamat);
                    $('#no_hp-edit').val(response.data.no_hp);
                    $('#modal-edit').modal('show');
                }
            });
        });

        $('#update').click(function(e) {
            e.preventDefault();
            let id = $('#id').val();
            let nama = $('#nama-edit').val();
            let alamat = $('#alamat-edit').val();
            let no_hp = $('#no_hp-edit').val();
            let token = $("meta[name='csrf-token']").attr("content");

            $.ajax({
                url: `/master/customer/${id}`,
                type: "PUT",
                cache: false,
                data: {
                    "nama": nama,
                    "alamat": alamat,
                    "no_hp": no_hp,
                    "_token": token
                },
                success: function(response) {
                    Toast.fire({
                        title: response.message
                    });

                    $('#modal-edit').modal('hide');
                    $('#table').DataTable().ajax.reload();
                },
                error: function(error) {
                    if (error.responseJSON.nama) {
                        $('#alert-nama-edit').removeClass('d-none');
                        $('#alert-nama-edit').addClass('d-block');
                        $('#alert-nama-edit').html(error.responseJSON.nama[0]);
                    }

                    if (error.responseJSON.alamat) {
                        $('#alert-alamat-edit').removeClass('d-none');
                        $('#alert-alamat-edit').addClass('d-block');
                        $('#alert-alamat-edit').html(error.responseJSON.alamat[0]);
                    }

                    if (error.responseJSON.no_hp) {
                        $('#alert-no_hp-edit').removeClass('d-none');
                        $('#alert-no_hp-edit').addClass('d-block');
                        $('#alert-no_hp-edit').html(error.responseJSON.no_hp[0]);
                    }
                }
            });
        });


        // delete data
        $('body').on('click', '#btn-delete', function() {
            let id = $(this).data('id');
            let token = $("meta[name='csrf-token']").attr("content");

            Swal.fire({
                title: 'Apakah Anda Yakin?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: 'Batal',
                confirmButtonText: 'Hapus',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/master/customer/${id}`,
                        type: 'DELETE',
                        data: {
                            "_token": token,
                        },
                        success: function(response) {
                            Toast.fire({
                                title: response.message
                            });
                            $('#table').DataTable().ajax.reload();
                        }
                    });
                }
            })
        });
    </script>
@endsection
