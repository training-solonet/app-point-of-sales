@extends('layouts.template')
@section('css')
@endsection
@section('content')
<div class="container-fluid">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Barang</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">Master/Barang</li>
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
            <a href="https://themesbrand.com/skote/layouts/form-elements.html" class="btn btn-primary mb-2"><i
                    class="uil uil-plus"></i> LINK TEMPLATE</a>
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-md-6 col-12">
                            <h4 class="card-title">Data Barang</h4>
                            <p class="card-title-desc">Anda dapat mengelola data barang disini.</p>
                        </div>
                        <div class="col-md-6">
                            <button type="button" class="btn btn-primary waves-effect waves-light float-md-end"
                                data-bs-toggle="modal" data-bs-target="#myModal" id="btn-create"><i
                                    class="fas fa-plus"></i> Tambah
                                Barang</button>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="table" class="table table-bordered dt-responsive  nowrap w-100">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Kode</th>
                                    <th>Part Number</th>
                                    <th>Nama</th>
                                    <th>Kategori</th>
                                    <th>Satuan</th>
                                    <th>Stok</th>
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
                    <h5 class="modal-title" id="myModalLabel">Tambah Barang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form action="/master/barang" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="nama" class="form-label">Kode</label>
                            <input type="text" class="form-control" id="kode" name="kode"
                                placeholder="Masukkan kode barang" required>
                        </div>
                        <div class="mb-3">
                            <label for="part_number" class="form-label">Part Number</label>
                            <input type="text" class="form-control" id="part_number" name="part_number"
                                placeholder="Masukkan part number barang" required>
                        </div>
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama"
                                placeholder="Masukkan part number barang">
                            <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-nama"></div>
                        </div>
                        <div class="mb-3">
                            <label for="satuan" class="form-label">Satuan</label>
                            <select class="form-select" id="satuan" name="id_satuan" required>
                                <option selected disabled value="">Pilih Satuan</option>
                                @foreach ($satuan as $s)
                                    <option value="{{ $s->id }}">{{ $s->nama }}</option>
                                @endforeach
                            </select>
                            <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-satuan"></div>
                        </div>
                        <div class="mb-3">
                            <label for="kategori" class="form-label">Kategori</label>
                            <select class="form-select select2" id="kategori" name="id_kategori" required>
                                <option selected disabled value="">Pilih Kategori</option>
                                @foreach ($kategori as $k)
                                    <option value="{{ $k->id }}">{{ $k->nama }}</option>
                                @endforeach
                            </select>
                            <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-kategori"></div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light" id="store"
                        name="proses">Simpan
                        Data</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <div id="UpModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Edit Barang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" name="barangForm">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="nama" class="form-label">Kode</label>
                            <input type="text" class="form-control" id="kode" name="kode"
                                placeholder="Masukkan kode barang" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="part_number" class="form-label">Part Number</label>
                            <input type="text" class="form-control" id="part_number" name="part_number"
                                placeholder="Masukkan part number barang">
                        </div>
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama"
                                placeholder="Masukkan part number barang">
                            <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-nama"></div>
                        </div>
                        <div class="mb-3">
                            <label for="satuan" class="form-label">Satuan</label>
                            <select class="form-select" id="satuan" name="id_satuan" required>
                                <option selected disabled value="">Pilih Satuan</option>
                                @foreach ($satuan as $s)
                                    <option value="{{ $s->id }}">{{ $s->nama }}</option>
                                @endforeach
                            </select>
                            <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-satuan"></div>
                        </div>
                        <div class="mb-3">
                            <label for="kategori" class="form-label">Kategori</label>
                            <select class="form-select" id="kategori" name="id_kategori" required>
                                <option selected disabled value="">Pilih Satuan</option>
                                @foreach ($kategori as $k)
                                    <option value="{{ $k->id }}">{{ $k->nama }}</option>
                                @endforeach
                            </select>
                            <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-kategori"></div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light" id="update"
                        name="proses">Simpan
                        Data</button>
                </div>
                </form>
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
                'url': "{{ route('master.barang.index') }}",
                'type': 'GET'
            },
            'columns': [
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'kode',
                    name: 'kode'
                },
                {
                    data: 'part_number',
                    name: 'part_number'
                },
                {
                    data: 'nama',
                    name: 'nama'
                },
                {
                    data: 'kategori.nama',
                    name: 'kategori.nama'
                },
                {
                    data: 'satuan.nama',
                    name: 'satuan.nama'
                },
                {
                    data: 'stok',
                    name: 'stok'
                },
                {
                    data: 'action',
                    name: 'action'
                }
            ]
        });

        $('body').on('click', '#btn-delete', function () {
            let id = $(this).data('id');
            let token = $("meta[name='csrf-token']").attr("content");

            // Delete
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
                        url: `/master/barang/${id}`,
                        type: 'DELETE',
                        data: {
                            "_token": token,
                        },
                        success: function (response) {
                            showToast(response.message, 'success');
                            $('#table').DataTable().ajax.reload();
                        }
                    });
                }
            })
        });

        // Create
        $('body').on('click', '#btn-create', function () {
            $('#myModal').modal('show');
            $('#myModal form')[0].reset();
        });

        $('#store').click(function (e) {
            e.preventDefault();
            let kode = $('#kode').val();
            let part_number = $('#part_number').val();
            let nama = $('#nama').val();
            let id_satuan = $('#satuan').val();
            let id_kategori = $('#kategori').val();
            let token = $("meta[name='csrf-token']").attr("content");
            $.ajax({
                url: '/master/barang',
                type: 'POST',
                cache: false,
                data: {
                    "_token": token,
                    "kode": kode,
                    "part_number": part_number,
                    "nama": nama,
                    "id_satuan": id_satuan,
                    "id_kategori": id_kategori
                },
                success: function (response) {
                    $('#myModal').modal('hide');
                    showToast('Barang berhasil ditambahkan', 'success');
                    $('#table').DataTable().ajax.reload();
                },
                error: function (error) {
                    if (error.responseJSON.kode) {
                        $('#alert-kode').removeClass('d-none');
                        $('#alert-kode').addClass('d-block');
                        $('#alert-kode').html(error.responseJSON.kode[0]);
                    }
                    if (error.responseJSON.part_number) {
                        $('#alert-part_number').removeClass('d-none');
                        $('#alert-part_number').addClass('d-block');
                        $('#alert-part_number').html(error.responseJSON.part_number[0]);
                    }
                    if (error.responseJSON.nama) {
                        $('#alert-nama').removeClass('d-none');
                        $('#alert-nama').addClass('d-block');
                        $('#alert-nama').html(error.responseJSON.nama[0]);
                    }
                    if (error.responseJSON.id_satuan) {
                        $('#alert-satuan').removeClass('d-none');
                        $('#alert-satuan').addClass('d-block');
                        $('#alert-satuan').html(error.responseJSON.id_satuan[0]);
                    }
                    if (error.responseJSON.id_kategori) {
                        $('#alert-kategori').removeClass('d-none');
                        $('#alert-kategori').addClass('d-block');
                        $('#alert-kategori').html(error.responseJSON.id_kategori[0]);
                    }
                }
            });
        });

        // Show
        $('body').on('click', '#btn-edit', function () {
            let id = $(this).data('id');

            $.ajax({
                url: `/master/barang/${id}`,
                type: "GET",
                cache: false,
                success: function (response) {
                    $('#UpModal #kode').val(response.data.kode);
                    $('#UpModal #part_number').val(response.data.part_number);
                    $('#UpModal #nama').val(response.data.nama);
                    $('#UpModal #satuan').val(response.data.id_satuan);
                    $('#UpModal #kategori').val(response.data.id_kategori);

                    $('#update').data('id', id);

                    $('#UpModal').modal('show');
                }
            });
        });

        // Update
        $('#update').click(function (e) {
            e.preventDefault();

            let id = $(this).data('id');
            let kode = $('#UpModal #kode').val();
            let part_number = $('#UpModal #part_number').val();
            let nama = $('#UpModal #nama').val();
            let id_satuan = $('#UpModal #satuan').val();
            let id_kategori = $('#UpModal #kategori').val();
            let token = $("meta[name='csrf-token']").attr("content");

            $.ajax({
                url: `/master/barang/${id}`,
                type: "PUT",
                cache: false,
                data: {
                    "kode": kode,
                    "part_number": part_number,
                    "nama": nama,
                    "id_satuan": id_satuan,
                    "id_kategori": id_kategori,
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