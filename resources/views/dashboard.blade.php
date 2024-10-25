@extends('layout.template', ['menu' => 'dashboard', 'submenu' => ''])

@section('title', 'Dashboard')

@section('content')
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
    <script src="{{ url('mobile/assets/js/chart-active.js') }}"></script>
@endsection
