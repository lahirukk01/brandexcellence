@extends('layouts.admin')

@section('title', 'Brand Excellence Admin Dashboard')

@section('breadcrumbs_title', 'Dashboard')

@section('breadcrumbs')
    <li class="active">Dashboard</li>
@endsection



@section('content')

    <div class="animated fadeIn">
        <div class="row">

            <div class="col-md-12">
                <div id="result-message"></div>
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center">Welcome</h3>
                    </div>
                    <div class="card-body">

                        <div class="col-sm-4 col-lg-4">
                            <div class="card text-white bg-flat-color-1">
                                <div class="card-body pb-0">
                                    <div class="dropdown float-right">
                                        <button class="btn bg-transparent dropdown-toggle theme-toggle text-light"
                                                type="button" id="dropdownMenuButton1" data-toggle="dropdown">
                                            <i class="fa fa-cog"></i>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                            <div class="dropdown-menu-content">
                                                <a class="dropdown-item" href="{{route('clients.index')}}">Go To Clients</a>
                                            </div>
                                        </div>
                                    </div>
                                    <h4 class="mb-0">
                                        <span class="count">{{ $data['clients'] }}</span>
                                    </h4>
                                    <p class="text-light">Clients</p>

                                    <div class="chart-wrapper px-0" style="height:70px;" height="70">
                                        <canvas id="widgetChart1"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-4 col-lg-4">
                            <div class="card text-white bg-flat-color-3">
                                <div class="card-body pb-0">
                                    <div class="dropdown float-right">
                                        <button class="btn bg-transparent dropdown-toggle theme-toggle text-light" type="button" id="dropdownMenuButton2" data-toggle="dropdown">
                                            <i class="fa fa-cog"></i>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                            <div class="dropdown-menu-content">
                                                <a class="dropdown-item" href="{{route('admin.brands.index')}}">Go To Brands</a>
                                            </div>
                                        </div>
                                    </div>
                                    <h4 class="mb-0">
                                        <span class="count">{{ $data['brands'] }}</span>
                                    </h4>
                                    <p class="text-light">Brands</p>

                                    <div class="chart-wrapper px-0" style="height:70px;" height="70">
                                        <canvas id="widgetChart2"></canvas>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="col-sm-4 col-lg-4">
                            <div class="card text-white bg-flat-color-4">
                                <div class="card-body pb-0">
                                    <div class="dropdown float-right">
                                        <button class="btn bg-transparent dropdown-toggle theme-toggle text-light" type="button" id="dropdownMenuButton3" data-toggle="dropdown">
                                            <i class="fa fa-cog"></i>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
                                            <div class="dropdown-menu-content">
                                                <a class="dropdown-item" href="{{route('admin.judges.index')}}">Go To Judges</a>
                                            </div>
                                        </div>
                                    </div>
                                    <h4 class="mb-0">
                                        <span class="count">{{ $data['judges'] }}</span>
                                    </h4>
                                    <p class="text-light">Judges</p>

                                </div>

                                <div class="chart-wrapper px-0" style="height:70px;" height="70">
                                    <canvas id="widgetChart3"></canvas>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="card-footer">

                    </div>
                </div>
            </div>


        </div>
    </div><!-- .animated -->

@endsection



@section('scripts')

    <script>
        $('#dashboard-li').addClass('active')
    </script>

@endsection