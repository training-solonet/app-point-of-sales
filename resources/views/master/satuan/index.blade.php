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
                            <button type="button" class="btn btn-primary waves-effect waves-light float-md-end" data-bs-toggle="modal" data-bs-target="#myModal">
                                <i class="fas fa-plus"></i> Tambah Satuan</button>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="table" class="table table-bordered dt-responsive  nowrap w-100">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Keterangan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($satuan as $s)
                                <tr>
                                    <td>{{$loop->iteration }}</td>
                                    <td>{{$s->nama}}</td>
                                    <td>{{$s->keterangan}}</td>

                                    <td>
                                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#UpModal{{$s->id}}">
                                            Edit
                                        </button>
                                        <form action="/master/satuan/{{$s->id}}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                        </form>
                                    </td>
                                        <!-- Modal update -->
                            <div id="UpModal{{$s->id}}" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel{{$s->id}}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="myModalLabel{{$s->id}}">Perbarui Data Satuan</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="/master/satuan/{{$s->id}}" method="POST">
                                                @csrf
                                                @method('PUT')

                                                <div class="mb-3">
                                                    <label for="nama{{$s->id}}" class="form-label">Nama</label>
                                                    <input type="text" class="form-control" id="nama{{$s->id}}" name="nama" placeholder="Enter Name" value="{{$s->nama}}">
                                                </div>
                                                <div class="row">
                                                        <div class="mb-3">
                                                            <label for="keterangan{{$s->id}}" class="form-label">Keterangan</label>
                                                            <input type="text" class="form-control" id="keterangan{{$s->id}}" name="keterangan" placeholder="Enter Information" value="{{$s->keterangan}}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Tutup</button>
                                                    <button type="submit" class="btn btn-primary waves-effect waves-light" name="proses">Simpan Data</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
                    <h5 class="modal-title" id="myModalLabel">Tambahkan Satuan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form action="/master/satuan" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" placeholder="Enter Name">
                        </div>
                        <div class="row">
    
                                <div class="mb-3">
                                    <label for="keterangan" class="form-label">Keterangan</label>
                                    <input type="text" class="form-control" id="keterangan" name="keterangan" placeholder="Enter information">
                                </div>
                            </div>

                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary waves-effect waves-light" name="proses">Simpan Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script>
    $(document).ready(function() {
        $('#table').DataTable();
    });
</script>
@endsection
