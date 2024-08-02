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
            <a href="https://themesbrand.com/skote/layouts/form-elements.html" class="btn btn-primary mb-2"><i class="uil uil-plus"></i> LINK TEMPLATE</a>
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-md-6 col-12">
                            <h4 class="card-title">Data Barang</h4>
                            <p class="card-title-desc">Anda dapat mengelola data barang disini.</p>
                        </div>
                        <div class="col-md-6">
                            <button type="button" class="btn btn-primary waves-effect waves-light float-md-end" data-bs-toggle="modal" data-bs-target="#myModal"><i class="fas fa-plus"></i> Tambah
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
                    <h5 class="modal-title" id="myModalLabel">Tambah Kategori</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form action="/master/barang" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="nama" class="form-label">Kode</label>
                            <input type="text" class="form-control" id="kode" name="kode" placeholder="Masukkan kode barang">
                        </div>
                        <div class="mb-3">
                            <label for="part_number" class="form-label">Part Number</label>
                            <input type="text" class="form-control" id="part_number" name="part_number" placeholder="Masukkan part number barang">
                        </div>
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan part number barang">
                        </div>
                        <div class="mb-3">
                            <label for="satuan" class="form-label">Satuan</label>
                            <select class="form-select" id="satuan" name="id_satuan" required>
                                <option selected disabled>Pilih Satuan</option>
                                <option value="1">BOX</option>
                                <option value="2">KEPING</option>
                                <option value="3">METER</option>
                                <option value="4">PACK</option>
                                <option value="5">PAKET</option>
                                <option value="6">PCS</option>
                                <option value="7">ROLL</option>
                                <option value="8">SET</option>
                                <option value="9">UNIT</option>
                                <option value="10">HASPEL</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="kategori" class="form-label">Kategori</label>
                            <select class="form-select" id="kategori" name="id_kategori" required>
                                <option selected disabled value="">Pilih Kategori</option>
                                <option value="1">Alat Jaringan</option>
                                <option value="2">Asesoris</option>
                                <option value="3">CCTV</option>
                                <option value="4">Komputer</option>
                                <option value="5">Peripheral</option>
                                <option value="6">Photography</option>
                                <option value="7">Lain-lain</option>
                            </select>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light" name="proses">Simpan
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
    
    $(document).ready(function() {
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 1000);
        // make datatable
        $('#table').DataTable({
            'responsive': true,
            'serverSide': true,
            'processing': true,
            'ajax': {
                'url': "{{ route('master.barang.index') }}",
                'type': 'GET'
            },
            'columns': [{
                    data: 'id',
                    name: 'id'
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

        $('body').on('click', '#btn-delete', function() {
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
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: response.message,
                                showConfirmButton: false,
                                timer: 1500
                            })
                            $('#table').DataTable().ajax.reload();
                        }
                    });
                }
            })
        });
    });
</script>

@endsection