@extends('template')
@section('title')
Dashboard
@endsection
@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Dashboard</h1>
    <p class="mb-4">Ini adalah data grafik pendapatan, pengeluaran dan produk.</p>
    <div class="row">
        <div class="col-xl-12 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Grafik Pendapatan & Pengeluaran</h6>
                </div>
            <div class="card-body">
                <div class="chart-area">
                    <canvas id="myAreaChart"></canvas>
                </div>
            <hr>Dalam grafik ini kita dapat melihat perbandingan pendapatan & pengeluaran, grafik ini ditampilkan dalam 1 tahun</hr>
        </div>
    </div>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Grafik Produk</h6>
            </div>
            <div class="card-body">
                <div class="chart-bar">
                    <canvas id="myBarChart"></canvas>
                </div>
                <hr>Dalam grafik ini kita dapat melihat perbandingan penjualan produk, grafik ini ditampilkan dalam 1 tahun</hr>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
  <script src="{{asset('assets/vendor/chart.js/Chart.min.js')}}"></script>
  <script src="{{asset('assets/js/demo/chart-area-demo.js')}}"></script>
  <script src="{{asset('assets/js/demo/chart-bar-demo.js')}}"></script>
@endsection