@extends('layouts.template')
@section('css')
    <style>
        input[type=number]::-webkit-outer-spin-button,
        input[type=number]::-webkit-inner-spin-button {
            -webkit-appearance: none;
        }
    </style>
@endsection
@section('content')
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Jurnal Harian</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item active">Menu/Jurnal-harian</li>
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
                                <h4 class="card-title">Data Jurnal Harian</h4>
                                <p class="card-title-desc">Anda dapat mengelola cash flow harian di halaman ini.</p>
                            </div>

                            <div class="col-md-6">
                                <button type="button" class="btn btn-primary waves-effect waves-light float-md-end"
                                    data-bs-toggle="modal" data-bs-target="#myModal" id="btn-create-post">
                                    <i class="fas fa-plus"></i> Tambah Data
                                </button>
                            </div>
                        </div>

                        <div class="saldo">
                            <p class="card-title-desc">Saldo : <strong id="saldo"> 0</strong>
                            </p>
                        </div>

                        <div class="table-responsive">
                            <table id="table" class="table table-bordered dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Tanggal</th>
                                        <th>Keterangan</th>
                                        <th>Debit</th>
                                        <th>Kredit</th>
                                        <th>Status</th>
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
    </div>

    <!-- Modal Create -->
    <div id="myModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Tambahkan Jurnal Harian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form id="form-create" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="tanggal" class="form-label">Tanggal</label>
                            <input type="date" class="form-control" id="tanggal" name="tanggal"
                                value="{{ date('Y-m-d') }}" placeholder="Enter date">
                            <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-tanggal"></div>
                        </div>

                        <div class="mb-3">
                            <label for="jenis" class="form-label">Jenis</label>
                            <select class="form-select" id="jenis" name="jenis" required>
                                <option selected disabled value="">Pilih Jenis</option>
                                <option value="Pemasukan">Pemasukan</option>
                                <option value="Pengeluaran">Pengeluaran</option>
                            </select>
                            <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-jenis"></div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-12">
                                <label for="nominal" class="form-label">Nominal</label>
                                <input type="number" class="form-control" id="nominal" name="nominal"
                                    placeholder="Enter Nominal ">
                                <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-nominal"></div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <textarea type="text" class="form-control" id="keterangan" name="keterangan" placeholder="Enter information"></textarea>
                            <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-keterangan"></div>
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Pilih Status</label>
                            <select class="form-select" id="id_status" name="status" required>
                                <option selected disabled value="">Pilih Status</option>
                                <option value="cash">Cash</option>
                                <option value="bank">Bank</option>
                            </select>
                            <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-status"></div>
                        </div>

                        <input type="hidden" id="debit" name="debit">
                        <input type="hidden" id="kredit" name="kredit">

                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary waves-effect waves-light" id="store">Simpan
                        Data</button>
                </div>
            </div>
        </div>
    </div>



    <!-- Modal Edit -->
    <div id="modal-edit" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Update Jurnal Harian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="form-edit" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="id" name="id">
                        <div class="mb-3">
                            <label for="tanggal" class="form-label">Tanggal</label>
                            <input type="date" class="form-control" id="tanggal-edit" name="tanggal">
                            <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-tanggal-edit"></div>
                        </div>
                        <div class="mb-3">
                            <label for="jenis" class="form-label">Jenis</label>
                            <select class="form-select" id="jenis-edit" name="jenis" required>
                                <option selected disabled value="">Pilih Jenis</option>
                                <option value="Pemasukan">Pemasukan</option>
                                <option value="Pengeluaran">Pengeluaran</option>
                            </select>
                            <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-jenis-edit"></div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-12">
                                <label for="nominal" class="form-label">Nominal</label>
                                <input type="number" class="form-control" id="nominal-edit" name="nominal">
                                <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-nominal-edit"></div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="keterangan-edit" class="form-label">Keterangan</label>
                            <input type="text" class="form-control" id="keterangan-edit" name="keterangan">
                            <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-keterangan-edit"></div>
                        </div>
                        <div class="mb-3">
                            <label for="status-edit" class="form-label">Pilih status</label>
                            <select class="form-select" id="status-edit" name="status" required>
                                <option selected disabled value="">Pilih status</option>
                                <option value="cash">cash</option>
                                <option value="bank">bank</option>
                            </select>
                            <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-status-edit"></div>
                        </div>
                    </form>
                </div>
                <input type="hidden" id="debit-edit" name="debit">
                <input type="hidden" id="kredit-edit" name="kredit">
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary waves-effect waves-light" id="update">Simpan
                        Data</button>
                </div>
            </div>
        </div>
    </div>


    </div>
@endsection

@section('js')
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });

        $(document).ready(function() {
            $('#table').DataTable({
                'responsive': true,
                'serverSide': true,
                'processing': true,
                'ajax': {
                    'url': "{{ route('menu.jurnal-harian.index') }}",
                    'type': 'GET'
                },
                'columns': [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'tanggal',
                        name: 'tanggal',
                        render: function(data, type, row) {
                            if (data) {
                                var date = new Date(data);
                                var day = ('0' + date.getDate()).slice(-2);
                                var month = ('0' + (date.getMonth() + 1)).slice(-2);
                                var year = date.getFullYear().toString();
                                return `${day}/${month}/${year}`;
                            }
                            return '';
                        }
                    },
                    {
                        data: 'keterangan',
                        name: 'keterangan'
                    },
                    {
                        data: 'debit',
                        name: 'debit',
                        className: "text-end",
                        render: $.fn.dataTable.render.number(',', '.', 0, 'Rp ')

                    },
                    {
                        data: 'kredit',
                        name: 'kredit',
                        className: "text-end",
                        render: $.fn.dataTable.render.number(',', '.', 0, 'Rp ')

                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],

            });

            get_saldo();

            // Simpan data
            $('#store').click(function(e) {
                e.preventDefault();
                let nominal = $('#nominal').val();
                let jenis = $('#jenis').val();

                if (jenis === 'Pemasukan') {
                    $('#debit').val(nominal);
                    $('#kredit').val(0);
                } else if (jenis === 'Pengeluaran') {
                    $('#debit').val(0);
                    $('#kredit').val(nominal);
                } else {
                    $('#debit').val(0);
                    $('#kredit').val(0);
                }
                let form = $('#form-create');

                $.ajax({
                    url: "{{ route('menu.jurnal-harian.store') }}",
                    type: 'POST',
                    data: form.serialize(),
                    success: function(response) {
                        if (response.success) {
                            $('#tanggal').val('');
                            // $('#debit').val('');
                            // $('#kredit').val('');
                            $('#jenis').val('');
                            $('#nominal').val('');
                            $('#keterangan').val('');
                            $('#status').val('');

                            $('#myModal').modal('hide');
                            $('#table').DataTable().ajax.reload();
                            Toast.fire({
                                icon: 'success',
                                title: response.message
                            });
                        }
                        get_saldo();
                    },
                    error: function(error) {
                        $('#alert-tanggal').toggleClass('d-none', !error.responseJSON.tanggal)
                            .html(error.responseJSON.tanggal ? error.responseJSON.tanggal[0] :
                                '');

                        $('#alert-jenis').toggleClass('d-none', !error.responseJSON
                            .jenis).html(error.responseJSON.jenis ? error
                            .responseJSON.jenis[0] : '');

                        $('#alert-nominal').toggleClass('d-none', !error.responseJSON
                            .nominal).html(error.responseJSON.nominal ? error
                            .responseJSON.nominal[0] : '');

                        $('#alert-keterangan').toggleClass('d-none', !error.responseJSON
                            .keterangan).html(error.responseJSON.keterangan ? error
                            .responseJSON.keterangan[0] : '');

                        $('#alert-status').toggleClass('d-none', !error.responseJSON.status)
                            .html(error.responseJSON.status ? error.responseJSON.status[0] :
                                '');
                    }
                });
            });

            $('body').on('click', '#btn-edit', function() {
                let id = $(this).data('id');
                $.ajax({
                    url: `/menu/jurnal-harian/${id}`,
                    type: "GET",
                    cache: false,
                    success: function(response) {
                        console.log('Nominal:', nominal);
                        console.log('Debit:', debit);
                        console.log('Kredit:', kredit);


                        $('#id').val(response.data.id);
                        $('#tanggal-edit').val(response.data.tanggal);
                        $('#keterangan-edit').val(response.data.keterangan);
                        $('#debit-edit').val(response.data.debit);
                        $('#kredit-edit').val(response.data.kredit);
                        $('#jenis-edit').val(response.data.jenis);
                        $('#nominal-edit').val(response.data.nominal);
                        $('#status-edit').val(response.data.status);

                        $('#modal-edit').modal('show');
                    }
                });
            });

            $('#jenis-edit').change(function() {
                let jenis = $(this).val();
                let nominal = parseFloat($('#nominal-edit').val()) || 0;

                if (jenis === 'Pemasukan') {
                    $('#debit-edit').val(nominal);
                    $('#kredit-edit').val('0');
                } else if (jenis === 'Pengeluaran') {
                    $('#debit-edit').val('0');
                    $('#kredit-edit').val(nominal);
                }
            });

            $('#update').click(function(e) {
                e.preventDefault();
                let id = $('#id').val();
                let tanggal = $('#tanggal-edit').val();
                let keterangan = $('#keterangan-edit').val();
                let debit = $('#debit-edit').val();
                let kredit = $('#kredit-edit').val();
                let jenis = $('#jenis-edit').val();
                let nominal = $('#nominal-edit').val();
                let status = $('#status-edit').val();
                let token = $("meta[name='csrf-token']").attr("content");

                $.ajax({
                    url: `/menu/jurnal-harian/${id}`,
                    type: "PUT",
                    cache: false,
                    data: {
                        "tanggal": tanggal,
                        "keterangan": keterangan,
                        "debit": debit,
                        "kredit": kredit,
                        "jenis": jenis,
                        "nominal": nominal,
                        "status": status,
                        "_token": token
                    },
                    success: function(response) {
                        if (response.success) {
                            Toast.fire({
                                icon: 'success',
                                title: response.message
                            });

                            $('#modal-edit').modal('hide');
                            $('#table').DataTable().ajax.reload();
                        } else {
                            Toast.fire({
                                icon: 'error',
                                title: response.message
                            });
                        }
                        get_saldo();
                    },
                    error: function(error) {
                        $('#alert-tanggal-edit, #alert-keterangan-edit, #alert-debit-edit, #alert-kredit-edit, #alert-status-edit')
                            .addClass('d-none').html('');

                        if (error.responseJSON.tanggal) {
                            $('#alert-tanggal-edit').removeClass('d-none').html(error
                                .responseJSON.tanggal[0]);
                        }

                        if (error.responseJSON.keterangan) {
                            $('#alert-keterangan-edit').removeClass('d-none').html(error
                                .responseJSON.keterangan[0]);
                        }

                        if (error.responseJSON.debit) {
                            $('#alert-debit-edit').removeClass('d-none').html(error.responseJSON
                                .debit[0]);
                        }

                        if (error.responseJSON.kredit) {
                            $('#alert-kredit-edit').removeClass('d-none').html(error
                                .responseJSON.kredit[0]);
                        }

                        $('#alert-jenis-edit').toggleClass('d-none', !error.responseJSON.jenis)
                            .html(error.responseJSON.jenis ? error.responseJSON.jenis[0] : '');
                        $('#alert-nominal-edit').toggleClass('d-none', !error.responseJSON
                            .nominal).html(error.responseJSON.nominal ? error.responseJSON
                            .nominal[0] : '');
                        if (error.responseJSON.status) {
                            $('#alert-status-edit').removeClass('d-none').html(error
                                .responseJSON.status[0]);
                        }
                    }
                });
            });




            // Hapus data
            $('body').on('click', '#btn-delete', function() {
                let id = $(this).data('id');
                let token = $("meta[name='csrf-token']").attr("content");

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
                            url: `/menu/jurnal-harian/${id}`,
                            type: "DELETE",
                            cache: false,
                            data: {
                                "_token": token
                            },
                            success: function(response) {
                                Toast.fire({

                                    title: response.message
                                });

                                $('#table').DataTable().ajax.reload();
                                get_saldo;
                            }
                        });
                    }
                })
            });



        });


        function get_saldo() {
            $.ajax({
                url: '/menu/jurnal-harian/create',
                type: "GET",
                cache: false,
                success: function(response) {
                    console.log(response)
                    $('#saldo').text(response.saldo);
                }
            });
        }
    </script>
@endsection
