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
                    <h4 id="invoice"></h4>
                    <h4 id="tanggal_beli"></h4>
                    <div class="row mb-2">
                        <div class="col-md-6 col-12">
                        </div>
                        <div class="col-md-6">
                            <button type="button" class="btn btn-primary waves-effect waves-light float-md-end"
                                data-bs-toggle="modal" data-bs-target="#myModal" id="btn-create"><i
                                    class="fas fa-plus"></i> Tambah
                                Barang</button>
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
                    <!-- <h4 class="text-center">Halaman Detail Barang Masuk</h4>
                    <p>1. Tampilkan sebuah record table pembelian di join dengan table detail_pembelian</p>
                    <p>2. Tambahkan 1 button "Masukan Ke Stok"</p>
                    <p>3. Dan ketika button tersebut di klik masukan data yang ditampilkan tersebut ke table stok</p>
                    <p>4. Di table stok, jual_id, tanggal_keluar, harga_jual, buat defaultnya null</p>
                    <p>5. Di table stok, harga_beli diambil dari perhitungan harga 1 buah barang</p> -->
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
        $.ajax({
            url: "/menu/barang-masuk/{{ $id }}",
            method: "GET",
            success: function (data) {
                $('#invoice').text('Invoice: ' + data.no_invoice)
                $('#tanggal_beli').text('Tanggal Beli: ' + data.tgl_beli)
            },
            error: function (xhr, status, error) {
                alert('Failed to load data: ' + error)
            }
        })

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
    })
</script>
@endsection