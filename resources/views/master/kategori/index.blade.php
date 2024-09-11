@extends('layouts.template')
@section('css')
@endsection
@section('content')
<div class="container-fluid">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Kategori</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">Master/Kategori</li>
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
                    <div class="row mb-2">
                        <div class="col-md-6 col-12">
                            <h4 class="card-title">Data Kategori</h4>
                            <p class="card-title-desc">Anda dapat mengelola kategori disini.</p>
                        </div>
                        <div class="col-md-6">
                            <button type="button" class="btn btn-primary waves-effect waves-light float-md-end"
                                data-bs-toggle="modal" data-bs-target="#myModal" id="btn-create"><i
                                    class="fas fa-plus"></i> Tambah
                                Kategori</button>
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
                                @foreach ($kategori as $k)
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>
                                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#UpModal"> Edit</button>
                                            <form action="{{ route('master.kategori.destroy', ) }}" style="display: inline;"
                                                method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                            </form>
                                        </td>
                                    </tr>


                                @endforeach
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
                    <h5 class="modal-title" id="myModalLabel">Tambah Kategori</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form action="/master/kategori" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama"
                                placeholder="Masukkan nama kategori" required>
                            <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-nama"></div>
                        </div>
                        <div class="mb-3">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <input type="text" class="form-control" id="keterangan" name="keterangan"
                                placeholder="Masukkan keterangan(opsional)">
                        </div>


                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary waves-effect"
                                data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary waves-effect waves-light" id="store"
                                name="proses">Simpan
                                Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="UpModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Perbarui Data Kategori</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama"
                            placeholder="Masukkan Nama Kategori" value="">
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-nama"></div>
                    </div>
                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <input type="text" class="form-control" id="keterangan" name="keterangan"
                            placeholder="Masukkan Keterangan" value="">
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-keterangan"></div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary waves-effect"
                            data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary waves-effect waves-light" id="update"
                            name="proses">Simpan
                            Data</button>
                    </div>
                    <!-- <form action="/master/kategori/" id="form-edit" method="POST">
                        @csrf
                        @method('PUT')

                        
                    </form> -->
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

        // Toast function
        function showToast(message, type) {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });

            Toast.fire({
                title: message
            });
        }

        // make datatable
        $('#table').DataTable({
            'responsive': true,
            'serverSide': true,
            'processing': true,
            'ajax': {
                'url': "{{ route('master.kategori.index') }}",
                'type': 'GET'
            },
            'columns': [{
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
                data: 'keterangan',
                name: 'keterangan'
            },
            {
                data: 'action',
                name: 'action'
            }
            ]
        });

        // Delete Kategori
        $('body').on('click', '#btn-delete', function () {
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
                        url: `/master/kategori/${id}`,
                        type: 'DELETE',
                        data: {
                            "_token": token,
                        },
                        success: function (response) {
                            if (response.success) {
                                showToast(response.message, 'success');
                            } else {
                                showToast(response.message, 'error');
                            }
                            $('#table').DataTable().ajax.reload();
                        },
                        error: function (xhr) {
                            if (xhr.status === 403) {
                                showToast(xhr.responseJSON.message, 'error');
                            }
                        }
                    });
                }
            })
        });

        // Create Kategori
        $('body').on('click', '#btn-create', function () {
            $('#myModal').modal('show');
            $('#myModal form')[0].reset();
        });
        $('#store').click(function (e) {
            e.preventDefault();
            let nama = $('#nama').val();
            let keterangan = $('#keterangan').val();
            let token = $("meta[name='csrf-token']").attr("content");
            $.ajax({
                url: `/master/kategori`,
                type: "POST",
                cache: false,
                data: {
                    "nama": nama,
                    "keterangan": keterangan,
                    "_token": token
                },
                success: function (response) {
                    $('#myModal').modal('hide');
                    showToast(response.message, 'success');
                    $('#table').DataTable().ajax.reload();
                },
                error: function (error) {
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

        // Show
        $('body').on('click', '#btn-edit', function () {
            let id = $(this).data('id');

            $.ajax({
                url: `/master/kategori/${id}`,
                type: "GET",
                cache: false,
                success: function (response) {
                    $('#UpModal #nama').val(response.data.nama);
                    $('#UpModal #keterangan').val(response.data.keterangan);

                    $('#update').data('id', id);

                    $('#UpModal').modal('show');
                }
            });
        });


        //update kategori
        $('#update').click(function (e) {
            e.preventDefault();

            let id = $(this).data('id');
            let nama = $('#UpModal #nama').val();
            let keterangan = $('#UpModal #keterangan').val();
            let token = $("meta[name='csrf-token']").attr("content");

            $.ajax({
                url: `/master/kategori/${id}`,
                type: "PUT",
                cache: false,
                data: {
                    "nama": nama,
                    "keterangan": keterangan,
                    "_token": token
                },
                success: function (response) {
                    showToast(response.message, 'success');

                    $('#table').DataTable().ajax.reload();
                    $('#UpModal').modal('hide');
                },
                error: function (error) {
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
    });
</script>
@endsection