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
                                data-bs-toggle="modal" data-bs-target="#myModal"><i class="fas fa-plus"></i> Tambah
                                Barang</button>
                        </div>
                    </div>

                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{$message}}</p>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table id="table" class="table table-bordered dt-responsive  nowrap w-100">
                            <thead>
                                <tr>
                                    <th>#</th>
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
                                @foreach ($barang as $b)
                                    <tr>
                                        <td>{{ ++$i }}</td>
                                        <td>{{ $b->kode }}</td>
                                        <td>{{ $b->part_number }}</td>
                                        <td>{{$b->nama}}</td>
                                        <td>{{$b->kategori->nama}}</td>
                                        <td>{{$b->satuan->nama}}</td>
                                        <td>{{$b->stok}}</td>
                                        <td>
                                            <a href="javascript:void(0)" class="btn btn-primary" data-id="{{ $b->id }}"
                                                id="editBarang">Edit</a>
                                            <form action="{{ route('master.barang.destroy', $b->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Delete</button>
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
    {{-- modal --}}
    <!-- sample modal content -->
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

                        <input type="hidden" name="barang_id" id="barang_id">
                        <div class="mb-3">
                            <label for="kode" class="form-label">Kode</label>
                            <input type="text" class="form-control" id="kode" name="kode" placeholder="Enter Kode">
                        </div>
                        <div class="mb-3">
                            <label for="part_number" class="form-label">Part Number</label>
                            <input type="text" class="form-control" id="part_number" name="part_number"
                                placeholder="Enter Part Number">
                        </div>
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" placeholder="Enter Nama">
                        </div>
                        <div class="mb-3">
                            <label for="id_kategori" class="form-label">Kategori</label>
                            <select class="form-select" id="id_kategori" name="id_kategori">
                                <option selected>Choose...</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="id_satuan" class="form-label">Satuan</label>
                            <select class="form-select" id="id_satuan" name="id_satuan">
                                <option selected>Choose...</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="stok" class="form-label">Stok</label>
                            <input type="number" class="form-control" id="stok" name="stok" placeholder="Enter Stok">
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary waves-effect"
                                data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary waves-effect waves-light" name="proses">Simpan
                                Data</button>
                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    {{-- modal --}}
    <!-- sample modal content -->
    <div id="myModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Create New Barang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="modal-body">
                        <div class="modal-body">
                            <form action="{{ route('master.barang.store') }}" id="barangForm" name="barangForm">
                                @csrf
                                <input type="hidden" name="barang_id" id="barang_id">
                                <div class="mb-3">
                                    <label for="kode" class="form-label">Kode</label>
                                    <input type="text" class="form-control" id="kode" name="kode"
                                        placeholder="Enter Kode">
                                </div>
                                <div class="mb-3">
                                    <label for="part_number" class="form-label">Part Number</label>
                                    <input type="text" class="form-control" id="part_number" name="part_number"
                                        placeholder="Enter Part Number">
                                </div>
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama</label>
                                    <input type="text" class="form-control" id="nama" name="nama"
                                        placeholder="Enter Nama">
                                </div>
                                <div class="mb-3">
                                    <label for="id_kategori" class="form-label">Kategori</label>
                                    <select class="form-select" id="id_kategori" name="id_kategori">
                                        <option selected>Choose...</option>
                                        <option value="1">Alat Jaringan</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="id_satuan" class="form-label">Satuan</label>
                                    <select class="form-select" id="id_satuan" name="id_satuan">
                                        <option selected>Choose...</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="stok" class="form-label">Stok</label>
                                    <input type="number" class="form-control" id="stok" name="stok"
                                        placeholder="Enter Stok">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary waves-effect waves-light" id="saveBtn">Save
                        changes</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /.modal -->
</div>
@endsection
@section('js')
<script>
    // make datatable
    $(document).ready(function () {
        $('#table').DataTable();
    });
</script>

@endsection