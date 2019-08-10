@extends('layouts.admin')

@section('title', 'Brand Excellence Admin Show Score R2')

@section('styles')
@endsection

@section('breadcrumbs_title', 'Scores R2')

@section('breadcrumbs')
    @if($direction == 'entrywise')
    <li><a href="{{route('admin.score.entry_wise')}}">Entry Wise R2</a></li>
    <li><a href="{{route('admin.score.entry_wise_judges', $brand->id)}}">Entry Wise Judges R2</a></li>
    @else
    <li><a href="{{route('admin.score.judge_wise')}}">Judge Wise R2</a></li>
    <li><a href="{{route('admin.score.judge_wise_entries', $judge->id)}}">Judge Wise Entries R2</a></li>
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
                            <div class="col-md-2">Round 2</div>
                            <div class="col-md-3">Entry Category: {{ $brand->category->name }}</div>
                        </div>

                        <div class="row mt-5">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Brand and CSR Intent<br>(10%)</th>
                                            <th>Brand TG and CSR Recipient<br>(5%)</th>
                                            <th>Brand Purpose and CSR Purpose<br>(10%)</th>
                                            <th>Brand Vision<br> (5%)</th>
                                            <th>Brand Mission</br>(5%)</th>
                                            <th>Brand Identity</br>(10%)</th>
                                            <th>Strategic Intent to Brand Intent</br>(25%)</th>
                                            <th>Key Activities and Link to CSR Strategy</br>(15%)</th>
                                            <th>Communication of CSR to Brand TG</br>(7%)</th>
                                            <th>Internal Communication to generate employee engagement</br>(8%)</th>
                                            <th>Total<br>(100%)</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td class="text-center">{{ $score->intent }}</td>
                                            <td class="text-center">{{ $score->recipient }}</td>
                                            <td class="text-center">{{ $score->purpose }}</td>
                                            <td class="text-center">{{ $score->vision }}</td>
                                            <td class="text-center">{{ $score->mission }}</td>
                                            <td class="text-center">{{ $score->identity }}</td>
                                            <td class="text-center">{{ $score->strategic }}</td>
                                            <td class="text-center">{{ $score->activities }}</td>
                                            <td class="text-center">{{ $score->communication }}</td>
                                            <td class="text-center">{{ $score->internal }}</td>
                                            <td class="text-center">{{ $score->total }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="11">Comments:</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">What is good?</td>
                                            <td colspan="9">
                                                <div class="form-group">{{ $score->good }}</div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">What is bad?</td>
                                            <td colspan="9">
                                                <div class="form-group">{{ $score->bad }}</div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">What needs to be improved?</td>
                                            <td colspan="9">
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
        $('#scores-r1-li').addClass('active')
        $('body').addClass('open')

    </script>

@endsection
