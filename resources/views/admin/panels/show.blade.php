
@extends('layouts.admin')

@section('title', 'Brand Excellence Admin Panel Show')


@section('styles')

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.18/r-2.2.2/sl-1.3.0/datatables.css"/>

@endsection


@section('breadcrumbs_title', 'Panels')

@section('breadcrumbs')
    <li><a href="{{route('admin.panel.index')}}">Panels</a></li>
    <li class="active">Panel</li>
@endsection


@section('content')

    <div class="animated fadeIn">
        <div class="row">
            @if (session('status'))
                <div class="alert alert-success alert-dismissible fade show floating-response" role="alert">
                    {{ session('status') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center">{{ $panel->name }}</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-4"><label for="">Auditor</label></div>
                                <div class="col-sm-8">{{ $panel->auditor->name }}</div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-4"><label for="">Categories</label></div>
                                <div class="col-sm-8">
                                    <ul>
                                        @foreach($panel->categories as $c)
                                            <li>{{ $c->name }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-4"><label for="">Judges</label></div>
                                <div class="col-sm-8">
                                    <ul>
                                        @foreach($panel->judges as $j)
                                            <li>{{ $j->name }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button id="submit-changes" class="btn btn-primary">Submit Changes</button>
                    </div>
                </div>
            </div>


        </div>
    </div><!-- .animated -->

@endsection



@section('scripts')

<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.18/r-2.2.2/sl-1.3.0/datatables.js"></script>

    <script>
        $('#panels-li').addClass('active')

    </script>

@endsection
