@extends('layouts.template')
@section('css')
@endsection
@section('content')
<div class="container-fluid">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">stok Masuk</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">Menu/stok-barang</li>
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
                    <h4 class="text-center">Halaman Detail Barang Masuk</h4>
                    <p>1. Tampilkan sebuah record table pembelian di join dengan table detail_pembelian</p>
                    <p>2. Tambahkan 1 button "Masukan Ke Stok"</p>
                    <p>3. Dan ketika button tersebut di klik masukan data yang ditampilkan tersebut ke table stok</p>
                    <p>4. Di table stok, jual_id, tanggal_keluar, harga_jual, buat defaultnya null</p>
                    <p>5. Di table stok, harga_beli diambil dari perhitungan harga 1 buah barang</p>
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

@endsection