@extends('layouts.template')
@section('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
<style>
    .dropdown-menu {
        max-height: 300px;
        overflow-y: scroll;
    }
</style>
<div class="container-fluid">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Penjualan</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">Report/Penjualan</li>
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
            <div class="card">
                <div class="card-body">
                    <div class="row ">
                        <div class="col-md-6 col-12">
                            <h4 class="card-title">Data Penjualan</h4>
                            <p class="card-title-desc">Data seluruh penjualan yang tercatat</p>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <div class="btn-group mb-3">
                            <button type="button" class="btn dropdown-toggle border border-black"
                                data-bs-toggle="dropdown" aria-expanded="false"><i
                                    class="bx bx-filter-alt"></i></button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="#">Default</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-filter="no_faktur">No Faktur</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-filter="nama_customer">Nama Customer</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item disabled" href="#" aria-disabled="true"><i
                                        class="bx bx-calendar-alt"></i> Tanggal</a>
                                <a class="dropdown-item" href="#" data-filter="tanggal_terbaru">Baru</a>
                                <a class="dropdown-item" href="#" data-filter="tanggal_terlama">Lama</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item disabled" href="#" aria-disabled="true"><i
                                        class="bx bx-calculator"></i> Total Pembelian</a>
                                <a class="dropdown-item" href="#" data-filter="total_terbesar">Besar</a>
                                <a class="dropdown-item" href="#" data-filter="total_terkecil">Kecil</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item disabled" href="#" aria-disabled="true"><i
                                        class="bx bx-money"></i> Bayar</a>
                                <a class="dropdown-item" href="#" data-filter="sudah_terbayar">Terbayar</a>
                                <a class="dropdown-item" href="#" data-filter="belum_terbayar">Belum Bayar</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item disabled" href="#" aria-disabled="true"><i
                                        class="bx bxs-bank"></i> Jenis Pembayaran</a>
                                <a class="dropdown-item" href="#" data-filter="bank">Bank</a>
                                <a class="dropdown-item" href="#" data-filter="cash">Cash</a>
                                <a class="dropdown-item" href="#" data-filter="piutang">Piutang</a>
                            </div>
                        </div><!-- /btn-group -->
                        <input type="hidden" id="filter" value="default">
                        <div class="mb-3">
                            <label class="form-label">Single Select</label>
                            <select class="form-control select2">
                                <option>Select</option>
                                <optgroup label="Alaskan/Hawaiian Time Zone">
                                    <option value="AK">Alaska</option>
                                    <option value="HI">Hawaii</option>
                                </optgroup>
                                <optgroup label="Pacific Time Zone">
                                    <option value="CA">California</option>
                                    <option value="NV">Nevada</option>
                                    <option value="OR">Oregon</option>
                                    <option value="WA">Washington</option>
                                </optgroup>
                                <optgroup label="Mountain Time Zone">
                                    <option value="AZ">Arizona</option>
                                    <option value="CO">Colorado</option>
                                    <option value="ID">Idaho</option>
                                    <option value="MT">Montana</option>
                                    <option value="NE">Nebraska</option>
                                    <option value="NM">New Mexico</option>
                                    <option value="ND">North Dakota</option>
                                    <option value="UT">Utah</option>
                                    <option value="WY">Wyoming</option>
                                </optgroup>
                                <optgroup label="Central Time Zone">
                                    <option value="AL">Alabama</option>
                                    <option value="AR">Arkansas</option>
                                    <option value="IL">Illinois</option>
                                    <option value="IA">Iowa</option>
                                    <option value="KS">Kansas</option>
                                    <option value="KY">Kentucky</option>
                                    <option value="LA">Louisiana</option>
                                    <option value="MN">Minnesota</option>
                                    <option value="MS">Mississippi</option>
                                    <option value="MO">Missouri</option>
                                    <option value="OK">Oklahoma</option>
                                    <option value="SD">South Dakota</option>
                                    <option value="TX">Texas</option>
                                    <option value="TN">Tennessee</option>
                                    <option value="WI">Wisconsin</option>
                                </optgroup>
                                <optgroup label="Eastern Time Zone">
                                    <option value="CT">Connecticut</option>
                                    <option value="DE">Delaware</option>
                                    <option value="FL">Florida</option>
                                    <option value="GA">Georgia</option>
                                    <option value="IN">Indiana</option>
                                    <option value="ME">Maine</option>
                                    <option value="MD">Maryland</option>
                                    <option value="MA">Massachusetts</option>
                                    <option value="MI">Michigan</option>
                                    <option value="NH">New Hampshire</option>
                                    <option value="NJ">New Jersey</option>
                                    <option value="NY">New York</option>
                                    <option value="NC">North Carolina</option>
                                    <option value="OH">Ohio</option>
                                    <option value="PA">Pennsylvania</option>
                                    <option value="RI">Rhode Island</option>
                                    <option value="SC">South Carolina</option>
                                    <option value="VT">Vermont</option>
                                    <option value="VA">Virginia</option>
                                    <option value="WV">West Virginia</option>
                                </optgroup>
                            </select>

                        </div>

                        <table id="table" class="table table-bordered dt-responsive  nowrap w-100">
                            <thead>
                                <tr>
                                    <th># </th>
                                    <th>No Faktur</th>
                                    <th>Customer</th>
                                    <th>Tanggal Pembelian</th>
                                    <th>Total</th>
                                    <th>Bayar</th>
                                    <th>Diskon</th>
                                    <th>PPN</th>
                                    <th>Status</th>
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
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function () {
        setTimeout(function () {
            $('.alert').fadeOut('slow');
        }, 1000);

        // Initialize datatable with filter
        var table = $('#table').DataTable({
            'responsive': true,
            'serverSide': true,
            'processing': true,
            'ajax': {
                'url': "{{ route('report.penjualan.index') }}",
                'type': 'GET',
                'data': function (d) {
                    d.filter = $('#filter').val();
                }
            },
            'columns': [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            },
            {
                data: 'no_faktur',
                name: 'no_faktur'
            },
            {
                data: 'customer.nama',
                name: 'customer.nama'
            },
            {
                data: 'tanggal',
                name: 'tanggal'
            },
            {
                data: 'total',
                name: 'total'
            },
            {
                data: 'bayar',
                name: 'bayar'
            },
            {
                data: 'diskon',
                name: 'diskon'
            },
            {
                data: 'ppn',
                name: 'ppn'
            },
            {
                data: 'status',
                name: 'status'
            }
            ]
        });

        // Handle filter change
        $('.dropdown-menu a').on('click', function () {
            var filterValue = $(this).data('filter');
            $('#filter').val(filterValue);
            table.ajax.reload();
        });
    });
</script>


@endsection