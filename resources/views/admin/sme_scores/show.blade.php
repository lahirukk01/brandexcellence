@extends('layouts.admin')

@section('title', 'Brand Excellence Admin Show SME Score R1')

@section('styles')
@endsection

@section('breadcrumbs_title', 'SME Scores R1')

@section('breadcrumbs')
    @if($direction == 'entrywise')
    <li><a href="{{route('admin.sme.score.entry_wise')}}">Entry Wise</a></li>
    <li><a href="{{route('admin.sme.score.entry_wise_judges', $brand->id)}}">Entry Wise Judges</a></li>
    @else
    <li><a href="{{route('admin.sme.score.judge_wise')}}">Judge Wise</a></li>
    <li><a href="{{route('admin.sme.score.judge_wise_entries', $judge->id)}}">Judge Wise Entries</a></li>
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
                        <h3 class="text-center">View Score R1</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">Judge Name: {{ $judge->name }}</div>
                            <div class="col-md-2">Entry ID: {{ $sme->id_string }}</div>
                            <div class="col-md-2">Brand: {{ $sme->brand_name }}</div>
                            <div class="col-md-2">Round 1</div>
                            <div class="col-md-3">Entry Category: {{ 'SME Brand of the Year' }}</div>
                        </div>

                        <div class="row mt-5">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Identification of Business Opportunity<br>(10%)</th>
                                            <th>Need Gap Satisfaction on Prior to Launch<br>(5%)</th>
                                            <th>Description of Target Audience<br>(5%)</th>
                                            <th>Targeting<br> (5%)</th>
                                            <th>Brand Name Decision</br>(5%)</th>
                                            <th>Brand Identity</br>(5%)</th>
                                            <th>POD/S</br>(10%)</th>
                                            <th>Application of Marketing Mix(Consider 4Ps)</br>(40%)</th>
                                            <th>Financial Performance (Sales, GP and/or NP)</br>(12%)</th>
                                            <th>Internal Communication to Generate Employee Engagement</br>(3%)</th>
                                            <th>Total<br>(100%)</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td class="text-center">{{ $smeScore->opportunity }}</td>
                                            <td class="text-center">{{ $smeScore->satisfaction }}</td>
                                            <td class="text-center">{{ $smeScore->description }}</td>
                                            <td class="text-center">{{ $smeScore->targeting }}</td>
                                            <td class="text-center">{{ $smeScore->decision }}</td>
                                            <td class="text-center">{{ $smeScore->identity }}</td>
                                            <td class="text-center">{{ $smeScore->pod }}</td>
                                            <td class="text-center">{{ $smeScore->marketing }}</td>
                                            <td class="text-center">{{ $smeScore->performance }}</td>
                                            <td class="text-center">{{ $smeScore->engagement }}</td>
                                            <td class="text-center">{{ $smeScore->total }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="11">Comments:</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">What is good?</td>
                                            <td colspan="9">
                                                <div class="form-group">{{ $smeScore->good }}</div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">What is bad?</td>
                                            <td colspan="9">
                                                <div class="form-group">{{ $smeScore->bad }}</div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">What needs to be improved?</td>
                                            <td colspan="9">
                                                <div class="form-group">{{ $smeScore->improvement }}</div>
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
        $('#scores-sme-r1-li').addClass('active')
        $('body').addClass('open')
    </script>

@endsection
