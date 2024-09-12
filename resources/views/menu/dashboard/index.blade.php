@extends('layouts.template')
@section('css')
    <style></style>
@endsection
@section('content')
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Dashboards</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item active">Menu/dashboard</li>
                        </ol>
                    </div>
                </div>

                <div class="row">

                    <div class="col-xl-3">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Penjualan Bulanan</h4>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <p class="text-muted" id="bulanRT">bulan ini</p>
                                        <h3>0</h3>
                                        <div class="mt-4">
                                            <a href="{{ route('report.penjualan.index') }}"
                                                class="btn btn-primary waves-effect waves-light btn-sm">View Detail <i
                                                    class="mdi mdi-arrow-right ms-1"></i></a>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mt-4 mt-sm-0">
                                            <div id="radialBar-chart" data-colors='["--bs-primary"]' class="apex-charts">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <p class="text-muted mb-2">List penjualan secara keseluruhan.</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-3">Stok Barang</h4>
                                <div class="row">
                                    <div class="col-8">
                                        <h3>{{ $totalStok }}</h3>
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
                                                    <i class="bx bx-copy-alt font-size-24"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="row">
            <div id="container" style="width:100%; height:400px;"></div>
        </div>

    </div>
@endsection

@section('js')
    {{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> --}}
    <script src="https://code.highcharts.com/highcharts.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const chart = Highcharts.chart('container', {
                chart: {
                    type: 'line'
                },
                title: {
                    text: 'Grafik Penjualan dan Pembelian'
                },
                xAxis: {
                    categories: ["Januari", "Februari", "Maret", "April", "Mei", "Juni",
                        "Juli", "Agustus", "September", "Oktober", "November", "Desember"
                    ]
                },
                yAxis: {
                    title: {
                        text: 'Total Laba'
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
                    }
                ]
            });
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
                        console.error('Failed to fetch saldo');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                }
            });
        }

        $(document).ready(function() {
            updateSaldo(); // Call the function on page load
        });
    </script>
@endsection
