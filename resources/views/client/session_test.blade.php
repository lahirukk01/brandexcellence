@extends('layouts.admin')

@section('title', 'Brand Excellence Admin Dashboard')

@section('breadcrumbs_title', 'Dashboard')

@section('breadcrumbs')
    <li class="active">Dashboard</li>
@endsection





@section('scripts')

    <script>
        $('#dashboard-li').addClass('active')
    </script>

@endsection