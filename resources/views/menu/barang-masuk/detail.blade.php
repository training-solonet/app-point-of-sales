@extends('layouts.template')
@section('css')
@endsection
@section('content')
<div class="container-fluid">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Barang Masuk</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">Menu/Barang Masuk</li>
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
                        </div>
                        <div class="col-md-6">
                            <button type="button" class="btn btn-warning waves-effect waves-light float-md-end"
                                id="addStok">Masukan Ke Stok</button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="table" class="table table-striped table-hover dt-responsive  nowrap w-100">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Barang</th>
                                    <th>Qty</th>
                                    <th>Harga Satuan</th>
                                    <th>Total Harga</th>
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
</div>


</div>
</div>
</div>
@endsection
@section('js')
<script>
    $(document).ready(function () {
        $('#table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "/menu/barang-masuk/{{ $id }}",
                type: "GET"
            },
            columns: [
                {
                    data: 'index',
                    name: 'index'
                },
                {
                    data: 'nama_barang',
                    name: 'nama_barang'
                },
                {
                    data: 'qty',
                    name: 'qty'
                },
                {
                    data: 'harga_satuan',
                    name: 'harga_satuan',
                    render: $.fn.dataTable.render.number(',', '.', 0, 'Rp ')
                },
                {
                    data: 'total_harga',
                    name: 'total_harga',
                    render: $.fn.dataTable.render.number(',', '.', 0, 'Rp ')
                }
            ]
        })

        $('#addStok').on('click', function () {
            $.ajax({
                url: "/menu/barang-masuk",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    pembelian_id: "{{ $id }}"
                },
                success: function (data) {
                    if (data.status == 'success') {
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'success',
                            title: data.message,
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                        }).then(function () {
                            window.location.href = "/menu/barang-masuk";
                        });
                    } else {
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'error',
                            title: data.message,
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                        });
                    }
                }
            });
        });

    })

</script>
@endsection