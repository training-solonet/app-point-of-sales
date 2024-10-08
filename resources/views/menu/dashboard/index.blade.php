@extends('layouts.template')
@section('css')
    <style>
        /* tampilan dekstop */
        .hehe {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }

        /* untuk tampilan hp */
        @media (max-width: 768px) {
            .hehe {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endsection
@section('content')
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Dashboards</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item active" id="tanggal">Menu/dashboard</li>

                        </ol>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-3">
                        <div class="card mini-stats-wid">
                            <a href="{{ route('master.customer.index') }}" style="color: inherit; text-decoration: none;">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <p class="text-muted fw-medium">Customer</p>
                                            <h4 class="mb-0">{{ number_format($totalCustomer) }}</h4>
                                        </div>
                                        <div class="flex-shrink-0 align-self-center">
                                            <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                                <span class="avatar-title">
                                                    <i class="fas fa-users font-size-24"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="card mini-stats-wid">
                            <a href="{{ route('menu.jurnal-harian.index') }}"
                                style="color: inherit; text-decoration: none;">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <p class="text-muted fw-medium">Saldo Jurnal Harian</p>
                                            <h4 class="mb-0" id="saldo">0</h4>
                                        </div>

                                        <div class="flex-shrink-0 align-self-center">
                                            <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                                <span class="avatar-title">
                                                    <i class="bx bx-transfer font-size-24"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="col-xl-3">
                        <div class="card mini-stats-wid">
                            <a href="{{ route('menu.jurnal-piutang.index') }}"
                                style="color: inherit; text-decoration: none;">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <p class="text-muted fw-medium">Piutang</p>
                                            <h4 class="mb-0">{{ $piutang }}</h4>
                                        </div>
                                        <div class="flex-shrink-0 align-self-center">
                                            <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                                <span class="avatar-title">
                                                    <i class="bx bx-copy-alt font-size-24"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="card mini-stats-wid">
                            <a href="{{ route('report.pembayaran-piutang.index') }}"
                                style="color: inherit; text-decoration: none;">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <p class="text-muted fw-medium">Piutang Lunas</p>
                                            <h4 class="mb-0">{{ $utangLunas }}</h4>
                                        </div>
                                        <div class="flex-shrink-0 align-self-center">
                                            <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                                <span class="avatar-title">
                                                    <i class="bx bxs-calendar-check font-size-24"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="col-xl-3">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-3">Stok Barang</h4>
                                <div class="row">
                                    <div class="col-8">
                                        <h3>{{ number_format($totalStok, 0, ',', '.') }}</h3>
                                    </div>
                                </div>

                                <p class="text-muted mt-2">Total Aset</p>
                                <div class="row">
                                    <div class="col-10">
                                        <h3>{{ number_format($totalAset, 0, ',', '.') }}</h3>
                                    </div>
                                </div>

                                <div class="col-sm-6 mt-2">
                                    <a href="{{ route('report.stok-barang.index') }}"
                                        class="btn btn-primary waves-effect waves-light btn-sm">View Detail <i
                                            class="mdi mdi-arrow-right ms-1"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 ">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Penjualan Bulanan</h4>
                                <div class="row">
                                    <div class="col-sm-12 mt-2 mb-2">
                                        <h2>{{ number_format($penjualanBulanan, 0, ',', '.') }}</h2>
                                        <p class="text-muted">Penjualan pada bulan <span id="bulan">ini</span></p>

                                    </div>
                                    <div class="col-sm-6 mt-4">
                                        <a href="{{ route('report.penjualan.index') }}"
                                            class="btn btn-primary waves-effect waves-light btn-sm">View Detail <i
                                                class="mdi mdi-arrow-right ms-1"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="hehe">
            <div class="mb-4" id="grafik-one" style="height: 400px;"></div>
            <div class="mb-4" id="grafik-two" style="height: 400px;"></div>
        </div>

    </div>
@endsection

@section('js')
    <script src="https://code.highcharts.com/highcharts.js"></script>

    <script>
        // function updateDateTime() {
        //     const now = new Date();

        //     // Format tanggal
        //    

        //     // Format waktu
        //     const timeOptions = {
        //         hour: '2-digit',
        //         minute: '2-digit',
        //         second: '2-digit',
        //         hour12: true
        //     };
        //     const formattedTime = now.toLocaleTimeString(undefined, timeOptions);
        //     document.getElementById('current-time').textContent = formattedTime;
        // }

        // setInterval(updateDateTime, 1000);
        // updateDateTime();

        function tanggal() {
            const now = new Date();

            const dateOptions = {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            };
            const formattedDate = now.toLocaleDateString(undefined, dateOptions);
            document.getElementById('tanggal').textContent = formattedDate;
        }

        tanggal();


        const namaBulan = [
            "Januari", "Februari", "Maret", "April", "Mei", "Juni",
            "Juli", "Agustus", "September", "Oktober", "November", "Desember"
        ];
        const currentMonth = new Date().getMonth();
        document.getElementById('bulan').textContent = namaBulan[currentMonth];

        document.addEventListener('DOMContentLoaded', function() {
            const chart = Highcharts.chart('grafik-one', {
                chart: {
                    type: 'line'
                },
                title: {
                    text: 'Grafik Penjualan dan Pembelian'
                },
                xAxis: {
                    categories: ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus",
                        "September", "Oktober", "November", "Desember"
                    ]
                },
                yAxis: {
                    title: {
                        text: ' '
                    },
                    labels: {
                        formatter: function() {
                            return this.value / 1000000 + ' jt';
                        }
                    }
                },
                series: [{
                        name: 'Penjualan',
                        data: @json($penjualanData).map(Number)
                    },
                    {
                        name: 'Pembelian',
                        data: @json($pembelianData).map(Number)
                    },
                ]
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const chart = Highcharts.chart('grafik-two', {
                chart: {
                    type: 'line'
                },
                title: {
                    text: 'Grafik Laba'
                },
                xAxis: {
                    categories: ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus",
                        "September", "Oktober", "November", "Desember"
                    ]
                },
                yAxis: {
                    title: {
                        text: ''
                    },
                    labels: {
                        formatter: function() {
                            return this.value / 1000000 + ' jt';
                        }
                    }
                },
                series: [{
                    name: 'Laba',
                    data: @json($totalLaba).map(Number)
                }, ]
            });
        });

        $(document).ready(function() {
            updateSaldo();
        });

        function updateSaldo() {
            $.ajax({
                url: '{{ route('jurnal-harian.saldo') }}',
                type: "GET",
                cache: false,
                success: function(response) {
                    if (response.success) {
                        $('#saldo').text(response.saldo);
                    } else {
                        console.error('Gagal');
                    }
                }
            });
        }
    </script>
@endsection
