@extends('layout.template', ['menu' => 'dashboard', 'submenu' => ''])

@section('title', 'Dashboard')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body direction-rtl">
                <div class="row">
                    <div class="col-4">
                        <div class="single-counter-wrap text-center">
                            <i class="fad fa-user text-theme fs-36px mb-2"></i>
                            <h4 class="mb-1 text-theme fs-28px">
                                <span class="counter">{{ $clientes }}</span>
                            </h4>
                            <p class="mb-0 fs-16px">Clientes</p>
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="single-counter-wrap text-center">
                            <i class="fad fa-shopping-cart text-theme fs-36px mb-2"></i>
                            <h4 class="mb-1 text-theme fs-28px">
                                <span class="counter">{{ $nVendas }}</span>
                            </h4>
                            <p class="mb-0 fs-16px"># Vendas</p>
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="single-counter-wrap text-center">
                            <i class="fad fa-circle-dollar text-theme fs-36px mb-2"></i>
                            <h4 class="mb-1 text-theme fs-28px">
                                <span class="counter">{{ number_format($vendas, 2, ',', '.') }}</span>
                            </h4>
                            <p class="mb-0 fs-16px">Valor Vendas</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container pt-3 mb-5">
        <div class="card mb-3">
            <div class="card-body border">
                <div class="row">
                    <di class="col-md-12">
                        <div class="charts-wrapper">
                            <div id="columnChart2"></div>
                        </div>
                    </di>
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-body border">
                <div class="row">
                    <di class="col-md-12">
                        <div class="chart-wrapper">
                            <div id="lineChart1"></div>
                        </div>
                    </di>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ url('mobile/assets/js/apexcharts.min.js') }}"></script>

    <script>
        var columnChart2 = {
            chart: {
                height: 180,
                type: 'bar',
                animations: {
                    enabled: true,
                    easing: 'easeinout',
                    speed: 1000
                },
                dropShadow: {
                    enabled: true,
                    opacity: 0.1,
                    blur: 2,
                    left: -1,
                    top: 5
                },
                zoom: {
                    enabled: false
                },
                toolbar: {
                    show: false
                },
            },
            title: {
                text: '',
                align: 'left',
                margin: 0,
                offsetX: 0,
                offsetY: 0,
                floating: true,
                style: {
                    fontSize: '14px',
                    color: '#8480ae'
                }
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '60%',
                    endingShape: 'rounded'
                },
            },
            colors: ['#0134d4'],
            dataLabels: {
                enabled: false
            },
            grid: {
                borderColor: '#dbeaea',
                strokeDashArray: 4,
                xaxis: {
                    lines: {
                        show: true
                    }
                },
                yaxis: {
                    lines: {
                        show: false,
                    }
                },
                padding: {
                    top: 0,
                    right: 0,
                    bottom: 0,
                    left: 0
                },
            },
            tooltip: {
                theme: 'dark',
                marker: {
                    show: true,
                },
                x: {
                    show: false,
                }
            },
            stroke: {
                show: true,
                colors: ['transparent'],
                width: 3
            },
            labels: ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15'],
            series: [{
                name: 'Venda',
                data: [320, 420, 395, 350, 410, 355, 360, 420, 320, 420, 395, 350, 410, 355, 360]
            }],
            xaxis: {
                crosshairs: {
                    show: true
                },
                labels: {
                    offsetX: 0,
                    offsetY: 0,
                    style: {
                        colors: '#8380ae',
                        fontSize: '10px'
                    },
                },
                tooltip: {
                    enabled: false,
                },
            },
            yaxis: {
                labels: {
                    offsetX: -10,
                    offsetY: 0,
                    style: {
                        colors: '#8380ae',
                        fontSize: '10px'
                    },
                }
            },
        }

        const columnCharts2 = document.getElementById('columnChart2');

        if (columnCharts2) {
            var columnChart_02 = new ApexCharts(columnCharts2, columnChart2);
            columnChart_02.render();
        }

        /* ULTIMOS 6 MESES */

        var lineChart1 = {
            chart: {
                height: 180,
                type: 'line',
                zoom: {
                    enabled: false
                },
                toolbar: {
                    show: false
                },
            },
            colors: ['#198754FF'],
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth'
            },
            title: {
                text: 'Últimos 6 meses de vendas',
                align: 'center',
                margin: 0,
                offsetX: 0,
                offsetY: 0,
                floating: true,
                style: {
                    fontSize: '14px',
                    color: '#8480ae',
                }
            },
            tooltip: {
                theme: 'dark',
                marker: {
                    show: true,
                },
                x: {
                    show: false,
                }
            },
            grid: {
                borderColor: '#dbeaea',
                strokeDashArray: 4,
                xaxis: {
                    lines: {
                        show: true
                    }
                },
                yaxis: {
                    lines: {
                        show: false,
                    }
                },
                padding: {
                    top: 0,
                    right: 0,
                    bottom: 0,
                    left: 0
                },
            },
            series: [{
                name: "Vendas",
                data: [100, 401, 305, 501, 409, 602]
            }],
            xaxis: {
                categories: ['Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out'],
                crosshairs: {
                    show: true
                },
                labels: {
                    offsetX: 0,
                    offsetY: 0,
                    style: {
                        colors: '#8380ae',
                        fontSize: '12px'
                    },
                },
                tooltip: {
                    enabled: false,
                },
            },
            yaxis: {
                labels: {
                    offsetX: -10,
                    offsetY: 0,
                    style: {
                        colors: '#8380ae',
                        fontSize: '12px'
                    },
                }
            }
        };

        const lineCharts1 = document.getElementById('lineChart1');

        if (lineCharts1) {
            var lineChart_1 = new ApexCharts(lineCharts1, lineChart1);
            lineChart_1.render();
        }
    </script>
@endsection
