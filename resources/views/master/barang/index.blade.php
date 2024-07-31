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

                    @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{$message}}</p>
                    </div>
                    @endif

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
                                @foreach ($barang as $b)
                                <tr>
                                    <td>{{ $b->id }}</td>
                                    <td>{{ $b->kode }}</td>
                                    <td>{{ $b->part_number }}</td>
                                    <td>{{$b->nama}}</td>
                                    <td>{{$b->kategori->nama}}</td>
                                    <td>{{$b->satuan->nama}}</td>
                                    <td>{{$b->stok}}</td>
                                    <td>
                                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#UpModal{{$b->id}}"> Edit</button>
                                        <form action="{{ route('master.barang.destroy', $b->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    </td>
                                </tr>

                                <div id="UpModal{{$b->id}}" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel{{$b->id}}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="myModalLabe{{$b->id}}l">Create New Barang</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="modal-body">
                                                    <div class="modal-body">
                                                        <form action="master/barang{{$b->id}}" name="barangForm">
                                                            @csrf
                                                            <div class="mb-3">
                                                                <label for="kode{{$b->id}}" class="form-label">Kode</label>
                                                                <input type="text" class="form-control" id="kode{{$b->id}}" name="kode" placeholder="Masukkan kode barang" value="{{$b->kode}}">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="part_number{{$b->id}}" class="form-label">Part Number</label>
                                                                <input type="text" class="form-control" id="part_number{{$b->id}}" name="part_number" placeholder="Masukkan part number barang" value="{{$b->part_number}}">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="nama{{$b->id}}" class="form-label">Nama</label>
                                                                <input type="text" class="form-control" id="nama{{$b->id}}" name="nama" placeholder="Masukkan part number barang" value="{{$b->nama}}">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="satuan{{$b->id}}" class="form-label">Satuan</label>
                                                                <select class="form-select" id="satuan{{$b->id}}" name="id_satuan" required>
                                                                    <option selected disabled value="{{$b->id_satuan}}">{{$b->satuan->nama}}</option>
                                                                    <option disabled value="">Pilih Satuan</option>
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
                                                                <label for="kategori{{$b->id}}" class="form-label">Kategori</label>
                                                                <select class="form-select" id="kategori{{$b->id}}" name="id_kategori" required>
                                                                    <option selected disabled value="{{$b->id_kategori}}">{{$b->kategori->nama}}</option>
                                                                    <option disabled value="">Pilih Kategori</option>
                                                                    <option value="1">Alat Jaringan</option>
                                                                    <option value="2">Asesoris</option>
                                                                    <option value="3">CCTV</option>
                                                                    <option value="4">Komputer</option>
                                                                    <option value="5">Peripheral</option>
                                                                    <option value="6">Photography</option>
                                                                    <option value="7">Lain-lain</option>
                                                                </select>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="stok{{$b->id}}" class="form-label">stok</label>
                                                                <input type="number" class="form-control" id="stok{{$b->id}}" name="stok" placeholder="Masukkan jumlah stok" value="{{$b->stok}}">
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
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary waves-effect waves-light" id="saveBtn">Save
                                                changes</button>
                                        </div>
                                    </div>
                                </div>
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
                                <option selected disabled value="">Pilih Satuan</option>
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
                        <div class="mb-3">
                            <label for="stok" class="form-label">stok</label>
                            <input type="number" class="form-control" id="stok" name="stok" placeholder="Masukkan jumlah stok">
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
@endsection
@section('js')
<script>
    // make datatable
    $(document).ready(function() {
        $('#table').DataTable();
    });
</script>

@endsection