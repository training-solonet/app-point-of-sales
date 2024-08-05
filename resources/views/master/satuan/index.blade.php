@extends('layouts.template')
@section('css')
@endsection
@section('content')
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Satuan</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item active">Master/Satuan</li>
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
                                <h4 class="card-title">Satuan</h4>
                                <p class="card-title-desc">Kelola data satuan disini.</p>
                            </div>

                            <div class="col-md-6">
                                <button type="button" class="btn btn-primary waves-effect waves-light float-md-end"
                                    data-bs-toggle="modal" data-bs-target="#myModal" id="btn-create-post">
                                    <i class="fas fa-plus"></i> Tambah Satuan</button>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="table" class="table table-bordered dt-responsive  nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama</th>
                                        <th>Keterangan</th>
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
                        <h5 class="modal-title" id="myModalLabel">Tambahkan Satuan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <form id="form-create" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama</label>
                                <input type="text" class="form-control" id="nama" name="nama"
                                    placeholder="Enter Name">
                                <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-nama"></div>
                            </div>
                            <div class="mb-3">
                                <label for="keterangan" class="form-label">Keterangan</label>
                                <input type="text" class="form-control" id="keterangan" name="keterangan"
                                    placeholder="Enter information">
                                <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-keterangan"></div>
                            </div>
                        </form>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Tutup</button>
                        <button type="button" class="btn btn-primary waves-effect waves-light" id="store">Simpan
                            Data</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Edit -->
        <div id="modal-edit" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">Update Satuan</h5>
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
                                <label for="keterangan-edit" class="form-label">Keterangan</label>
                                <input type="text" class="form-control" id="keterangan-edit" name="keterangan"
                                    placeholder="Enter information">
                                <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-keterangan-edit">
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
        $(document).ready(function() {
            // Show data
            $('#table').DataTable({
                "responsive": true,
                "serverSide": true,
                "processing": true,
                "ajax": {
                    "url": "{{ route('master.satuan.index') }}",
                    "type": "GET"
                },
                "columns": [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'keterangan',
                        name: 'keterangan'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    }
                ]
            });

            // Create data
            $('body').on('click', '#btn-create-post', function() {
                $('#myModal').modal('show');
            });

            $('#store').click(function(e) {
                e.preventDefault();
                let nama = $('#nama').val();
                let keterangan = $('#keterangan').val();
                let token = $("meta[name='csrf-token']").attr("content");

                $.ajax({
                    url: `/master/satuan`,
                    type: "POST",
                    cache: false,
                    data: {
                        "nama": nama,
                        "keterangan": keterangan,
                        "_token": token
                    },
                    success: function(response) {
                        Swal.fire({
                            type: 'success',
                            icon: 'success',
                            title: `${response.message}`,
                            showConfirmButton: false,
                            timer: 1500
                        });

                        $('#myModal').modal('hide');
                        $('#table').DataTable().ajax.reload();
                    },
                    error: function(error) {
                        if (error.responseJSON.nama) {
                            $('#alert-nama').removeClass('d-none');
                            $('#alert-nama').addClass('d-block');
                            $('#alert-nama').html(error.responseJSON.nama[0]);
                        }

                        if (error.responseJSON.keterangan) {
                            $('#alert-keterangan').removeClass('d-none');
                            $('#alert-keterangan').addClass('d-block');
                            $('#alert-keterangan').html(error.responseJSON.keterangan[0]);
                        }
                    }
                });
            });

            // Edit data
            $('body').on('click', '#btn-edit-post', function() {
                let id = $(this).data('id');
                $.ajax({
                    url: `/master/satuan/${id}`,
                    type: "GET",
                    cache: false,
                    success: function(response) {
                        $('#id').val(response.data.id);
                        $('#nama-edit').val(response.data.nama);
                        $('#keterangan-edit').val(response.data.keterangan);
                        $('#modal-edit').modal('show');
                    }
                });
            });

            $('#update').click(function(e) {
                e.preventDefault();
                let id = $('#id').val();
                let nama = $('#nama-edit').val();
                let keterangan = $('#keterangan-edit').val();
                let token = $("meta[name='csrf-token']").attr("content");

                $.ajax({
                    url: `/master/satuan/${id}`,
                    type: "PUT",
                    cache: false,
                    data: {
                        "nama": nama,
                        "keterangan": keterangan,
                        "_token": token
                    },
                    success: function(response) {
                        Swal.fire({
                            type: 'success',
                            icon: 'success',
                            title: `${response.message}`,
                            showConfirmButton: false,
                            timer: 1500
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

                        if (error.responseJSON.keterangan) {
                            $('#alert-keterangan-edit').removeClass('d-none');
                            $('#alert-keterangan-edit').addClass('d-block');
                            $('#alert-keterangan-edit').html(error.responseJSON.keterangan[0]);
                        }
                    }
                });
            });

            // Delete data
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
                            url: `/master/satuan/${id}`,
                            type: "DELETE",
                            cache: false,
                            data: {
                                "_token": token
                            },
                            success: function(response) {
                                Swal.fire({
                                    type: 'success',
                                    icon: 'success',
                                    title: `${response.message}`,
                                    showConfirmButton: false,
                                    timer: 3000
                                });

                                $('#table').DataTable().ajax.reload();
                            }
                        });
                    }
                })
            });

        });
    </script>
@endsection
