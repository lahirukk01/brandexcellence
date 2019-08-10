@extends('layouts.admin')

@section('title', 'Brand Excellence Admin Show Score')

@section('styles')
@endsection

@section('breadcrumbs_title', 'Scores R2')

@section('breadcrumbs')
    @if($direction == 'entrywise')
    <li><a href="{{route('admin.score.entry_wise2')}}">Entry Wise R2</a></li>
    <li><a href="{{route('admin.score.entry_wise_judges2', $brand->id)}}">Entry Wise Judges R2</a></li>
    @else
    <li><a href="{{route('admin.score.judge_wise2')}}">Judge Wise R2</a></li>
    <li><a href="{{route('admin.score.judge_wise_entries2', $judge->id)}}">Judge Wise Entries R2</a></li>
    @endif
    <li class="active">View Score</li>
@endsection



@section('content')

    <div class="animated fadeIn">
        <div class="row">
            <div class="col-md-12">
                <div id="result-message"></div>
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center">View Score R2</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">Judge Name: {{ $judge->name }}</div>
                            <div class="col-md-2">Entry ID: {{ $brand->id_string }}</div>
                            <div class="col-md-2">Brand: {{ $brand->name }}</div>
                            <div class="col-md-2">Round 1</div>
                            <div class="col-md-3">Entry Category: {{ $brand->category->name }}</div>
                        </div>

                        <div class="row mt-5">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Brand Intent<br>(15%)</th>
                                                <th>Brand Content<br>(15%)</th>
                                                <th>Brand Process<br>(40%)</th>
                                                <th>Brand Health<br>KPI'S (18%)</th>
                                                <th>Financial</br>Performance(12%)</th>
                                                <th>Total<br>(100%)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="text-center">{{ $score->intent }}</td>
                                                <td class="text-center">{{ $score->content }}</td>
                                                <td class="text-center">{{ $score->process }}</td>
                                                <td class="text-center">{{ $score->health }}</td>
                                                <td class="text-center">{{ $score->performance }}</td>
                                                <td class="text-center">{{ $score->total }}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="6">Comments:</td>
                                            </tr>
                                            <tr>
                                                <td>What is good?</td>
                                                <td colspan="5">
                                                    <div class="form-group">{{ $score->good }}</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>What is bad?</td>
                                                <td colspan="5">
                                                    <div class="form-group">{{ $score->bad }}</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>What needs to be improved?</td>
                                                <td colspan="5">
                                                    <div class="form-group">{{ $score->improvement }}</div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
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
        $('#scores-r2-li').addClass('active')

    </script>

@endsection
