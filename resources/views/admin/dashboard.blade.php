<?php
use App\Account;use App\Order;use function App\Helpers\jdate;
?>
@extends('layouts.dashboard')
@section("title","داشبورد")
@section("content")
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h5 class="m-0">داشبورد</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @if(auth()->user()->permission == 1)
                                <div class="col-lg-3 col-6">
                                    <!-- small box -->
                                    <div class="small-box bg-info">
                                        <div class="inner">
                                            <h3>{{App\User::all()->count()}}</h3>

                                            <p>تعداد کابران</p>
                                        </div>
                                        <div class="icon">
                                            <i class="ion ion-bag"></i>
                                        </div>
                                        <a href="{{url("users")}}" class="small-box-footer">لیست کاربران <i class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>
                                    <div class="col-lg-3 col-6">
                                        <!-- small box -->
                                        <div class="small-box bg-warning">
                                            <div class="inner">
                                                <h3><?PHP
                                                    echo Order::all()->count();
                                                    ?></h3>

                                                <p>تعداد کل سفارشات</p>
                                            </div>
                                            <div class="icon">
                                                <i class="ion ion-person-add"></i>
                                            </div>
                                            <a href="{{url("all-orders")}}" class="small-box-footer">لیست تمام سفارشات</a>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-6">
                                        <!-- small box -->
                                        <div class="small-box bg-primary">
                                            <div class="inner">
                                                <h3><?PHP
                                                    echo Account::all()->count();
                                                    ?></h3>

                                                <p>تعداد کل اکانت ها</p>
                                            </div>
                                            <div class="icon">
                                                <i class="ion ion-stats-bars"></i>
                                            </div>
                                            <a href="{{url("accounts-all")}}" class="small-box-footer">لیست تمامی اکانت ها</a>
                                        </div>
                                    </div>
                                @endif
                                <!-- ./col -->
                                <div class="col-lg-3 col-6">
                                    <!-- small box -->
                                    <div class="small-box bg-success">
                                        <div class="inner">
                                            <h3><?PHP
                                                echo Account::where("user_id",auth()->user()->id)->get()->count();
                                                ?></h3>

                                            <p>تعداد اکانت های من</p>
                                        </div>
                                        <div class="icon">
                                            <i class="ion ion-stats-bars"></i>
                                        </div>
                                        <a href="{{url("accounts")}}" class="small-box-footer">لیست تمامی اکانت های من</a>
                                    </div>
                                </div>
                                <!-- ./col -->
                                <div class="col-lg-3 col-6">
                                    <!-- small box -->
                                    <div class="small-box bg-warning">
                                        <div class="inner">
                                            <h3><?PHP
                                                echo Order::where("user_id",auth()->user()->id)->get()->count();
                                                ?></h3>

                                            <p>تعداد سفارشات من</p>
                                        </div>
                                        <div class="icon">
                                            <i class="ion ion-person-add"></i>
                                        </div>
                                        <a href="{{url("orders")}}" class="small-box-footer">تمام سفارشات من</a>
                                    </div>
                                </div>
                                    <!-- ./col -->
                                <!-- ./col -->
                                <div class="col-lg-3 col-6">
                                    <!-- small box -->
                                    <div class="small-box bg-danger">
                                        <div class="inner">
                                            <h3>تاریخ</h3>

                                            <p>و ساعت</p>
                                        </div>
                                        <a href="#" class="small-box-footer"><?=jdate("Y/m/d H:i:s")?></a>
                                    </div>
                                </div>
                                <!-- ./col -->
                            </div>
                        </div>
                    </div>
{{--                    <div class="card">--}}
{{--                        <div class="card-header ui-sortable-handle" style="cursor: move;">--}}
{{--                            <h3 class="card-title">--}}
{{--                                <i class="fas fa-chart-pie mr-1"></i>--}}
{{--                                نمودار سفارشات--}}
{{--                            </h3>--}}
{{--                        </div><!-- /.card-header -->--}}
{{--                        <div class="card-body">--}}
{{--                            <div class="tab-content p-0">--}}
{{--                                <!-- Morris chart - Sales -->--}}
{{--                                <div class="chart tab-pane active" id="revenue-chart" style="position: relative; height: 300px;"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>--}}
{{--                                    <canvas id="revenue-chart-canvas" height="300" style="height: 300px; display: block; width: 615px;" width="615" class="chartjs-render-monitor"></canvas>--}}
{{--                                </div>--}}
{{--                                <div class="chart tab-pane" id="sales-chart" style="position: relative; height: 300px;">--}}
{{--                                    <canvas id="sales-chart-canvas" height="0" style="height: 0px; display: block; width: 0px;" class="chartjs-render-monitor" width="0"></canvas>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div><!-- /.card-body -->--}}
{{--                    </div>--}}
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
@endsection
@section("custom_script")
    <script src="{{asset("plugins/chart.js/Chart.min.js")}}"></script>
    <script>
        var salesChartData = {
            labels  : ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
            datasets: [
                {
                    label               : 'Digital Goods',
                    backgroundColor     : 'rgba(60,141,188,0.9)',
                    borderColor         : 'rgba(60,141,188,0.8)',
                    pointRadius          : false,
                    pointColor          : '#3b8bba',
                    pointStrokeColor    : 'rgba(60,141,188,1)',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    data                : [28, 48, 40, 19, 86, 27, 90]
                },
                {
                    label               : 'Electronics',
                    backgroundColor     : 'rgba(210, 214, 222, 1)',
                    borderColor         : 'rgba(210, 214, 222, 1)',
                    pointRadius         : false,
                    pointColor          : 'rgba(210, 214, 222, 1)',
                    pointStrokeColor    : '#c1c7d1',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(220,220,220,1)',
                    data                : [65, 59, 80, 81, 56, 55, 40]
                },
            ]
        }
        var salesChartCanvas = document.getElementById('revenue-chart-canvas').getContext('2d');
        var salesChartOptions = {
            maintainAspectRatio : false,
            responsive : true,
            legend: {
                display: false
            },
            scales: {
                xAxes: [{
                    gridLines : {
                        display : false,
                    }
                }],
                yAxes: [{
                    gridLines : {
                        display : false,
                    }
                }]
            }
        }
        var salesChart = new Chart(salesChartCanvas, {
                type: 'line',
                data: salesChartData,
                options: salesChartOptions
            }
        )
    </script>
@endsection()
