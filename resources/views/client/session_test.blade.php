@extends('layouts.client')

@section('title', 'Brand Excellence Client Session Test')

@section('breadcrumbs_title', 'Dashboard')

@section('breadcrumbs')
    <li class="active">Session Test</li>
@endsection


@section('content')
<?php
echo '<pre>';
print_r(session('brands'));
echo '</pre>';
?>
@endsection


@section('scripts')

{{--    <script>--}}
{{--        $('#dashboard-li').addClass('active')--}}
{{--    </script>--}}

@endsection