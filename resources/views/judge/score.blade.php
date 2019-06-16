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