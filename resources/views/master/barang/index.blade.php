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
                            <button type="button" class="btn btn-primary waves-effect waves-light float-md-end" data-bs-toggle="modal" data-bs-target="#myModal"><i class="fas fa-plus"></i> Tambah Barang</button>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="table" class="table table-bordered dt-responsive  nowrap w-100">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Kode</th>
                                    <th>Nama</th>
                                    <th>Satuan</th>
                                    <th>Kategori</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>BRG001</td>
                                    <td>Indomie</td>
                                    <td>Pcs</td>
                                    <td>Makanan</td>
                                    <td>
                                        <a href="https://themesbrand.com/skote/layouts/form-elements.html" class="btn btn-warning btn-sm"><i class="uil uil-edit"></i> Edit</a>
                                        <a href="https://themesbrand.com/skote/layouts/form-elements.html" class="btn btn-danger btn-sm"><i class="uil uil-trash-alt"></i> Hapus</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>BRG002</td>
                                    <td>Indomie Goreng</td>
                                    <td>Pcs</td>
                                    <td>Makanan</td>
                                    <td>
                                        <a href="https://themesbrand.com/skote/layouts/form-elements.html" class="btn btn-warning btn-sm"><i class="uil uil-edit"></i> Edit</a>
                                        <a href="https://themesbrand.com/skote/layouts/form-elements.html" class="btn btn-danger btn-sm"><i class="uil uil-trash-alt"></i> Hapus</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>BRG003</td>
                                    <td>Indomie Soto</td>
                                    <td>Pcs</td>
                                    <td>Makanan</td>
                                    <td>
                                        <a href="https://themesbrand.com/skote/layouts/form-elements.html" class="btn btn-warning btn-sm"><i class="uil uil-edit"></i> Edit</a>
                                        <a href="https://themesbrand.com/skote/layouts/form-elements.html" class="btn btn-danger btn-sm"><i class="uil uil-trash-alt"></i> Hapus</a>
                                    </td>
                                </tr>
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
                    <h5 class="modal-title" id="myModalLabel">Default Modal Heading</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="formrow-firstname-input" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="formrow-firstname-input" placeholder="Enter Your First Name">
                        </div>

                        <div class="row">
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="formrow-email-input" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="formrow-email-input" placeholder="Enter Your Email ID">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="formrow-password-input" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="formrow-password-input" placeholder="Enter Your Password">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label for="formrow-inputCity" class="form-label">City</label>
                                    <input type="text" class="form-control" id="formrow-inputCity" placeholder="Enter Your Living City">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label for="formrow-inputState" class="form-label">State</label>
                                    <select id="formrow-inputState" class="form-select">
                                        <option selected>Choose...</option>
                                        <option>...</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-lg-4">
                                <div class="mb-3">
                                    <label for="formrow-inputZip" class="form-label">Zip</label>
                                    <input type="text" class="form-control" id="formrow-inputZip" placeholder="Enter Your Zip Code">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary waves-effect waves-light">Save changes</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
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