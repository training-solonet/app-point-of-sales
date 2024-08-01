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
        <div class="card">
            <div class="card-body">
                <form action="/master/satuan" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Enter Name" required>
                    </div>
                    <div class="row">

                        <div class="mb-3">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <input type="text" class="form-control" id="keterangan" name="keterangan"
                                placeholder="Enter information">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
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