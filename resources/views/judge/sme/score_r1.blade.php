@extends('layouts.judge')

@section('title', 'Brand Excellence Judge Score SME Entry')

@section('styles')
    <style>
        .score-input {
            width: 100%;
        }

        #entries-sme-r1-li.active > i {
         color: white !important;
        }

    </style>
@endsection

@section('breadcrumbs_title', 'SME Entries')

@section('breadcrumbs')
    <li><a href="{{route('judge.sme.index_r1')}}">SME Entries R1</a></li>
    <li class="active">Score</li>
@endsection



@section('content')

    <div class="animated fadeIn">

        @if( $errors->any())
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-danger">
                        <ul>
                            @foreach( $errors->all() as $e)
                                <li>{{ $e }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <div class="row">
            <div class="col-md-12">
                <div id="result-message"></div>
                <div class="card">
                    <form action="{{ route('judge.sme.store_r1', $sme->id) }}" method="post">
                        @csrf
                        <div class="card-body">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md-3">Judge Name: {{ Auth::user()->name }}</div>
                                    <div class="col-md-2">Entry ID: {{ $sme->id_string }}</div>
                                    <div class="col-md-2">Brand: {{ $sme->brand_name }}</div>
                                    <div class="col-md-2">Round 1</div>
                                    <div class="col-md-3">Entry Category: {{ 'SME Brand of the Year' }}</div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
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
                                                    <td>
                                                        <input class="score-input" type="number" name="opportunity" id=""
                                                               required data-validation="required number" step="0.01" min="0" max="10"
                                                               data-validation-allowing="float range[0;10]">
                                                    </td>
                                                    <td>
                                                        <input class="score-input" type="number" name="satisfaction" id="" min="0" max="5"
                                                               required data-validation="required number" step="0.01"
                                                               data-validation-allowing="float range[0;5]">
                                                    </td>
                                                    <td>
                                                        <input class="score-input" type="number" name="description" id="" min="0" max="5"
                                                               required data-validation="required number" step="0.01"
                                                               data-validation-allowing="float range[0;5]">
                                                    </td>
                                                    <td>
                                                        <input class="score-input" type="number" name="targeting" id="" min="0" max="5"
                                                               required data-validation="required number" step="0.01"
                                                               data-validation-allowing="float range[0;5]">
                                                    </td>
                                                    <td>
                                                        <input class="score-input" type="number" name="decision" id="" min="0" max="5"
                                                               required data-validation="required number" step="0.01"
                                                               data-validation-allowing="float range[0;5]">
                                                    </td>
                                                    <td>
                                                        <input class="score-input" type="number" name="identity" id="" min="0" max="5"
                                                               required data-validation="required number" step="0.01"
                                                               data-validation-allowing="float range[0;5]">
                                                    </td>
                                                    <td>
                                                        <input class="score-input" type="number" name="pod" id="" min="0" max="10"
                                                               required data-validation="required number" step="0.01"
                                                               data-validation-allowing="float range[0;10]">
                                                    </td>
                                                    <td>
                                                        <input class="score-input" type="number" name="marketing" id="" min="0" max="40"
                                                               required data-validation="required number" step="0.01"
                                                               data-validation-allowing="float range[0;40]">
                                                    </td>
                                                    <td>
                                                        <input class="score-input" type="number" name="performance" id="" min="0" max="12"
                                                               required data-validation="required number" step="0.01"
                                                               data-validation-allowing="float range[0;12]">
                                                    </td>
                                                    <td>
                                                        <input class="score-input" type="number" name="engagement" id="" min="0" max="3"
                                                               required data-validation="required number" step="0.01"
                                                               data-validation-allowing="float range[0;3]">
                                                    </td>
                                                    <td class="text-center">
                                                        <span id="total-score"></span>
                                                        <input type="hidden" name="total" id="total-score-input">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="11">Comments:</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">What is good?</td>
                                                    <td colspan="9">
                                                        <div class="form-group">
                                                            <textarea name="good" id="" cols="30" rows="4" class="form-control" data-validation="required"></textarea>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">What is bad?</td>
                                                    <td colspan="9">
                                                        <div class="form-group">
                                                            <textarea name="bad" id="" cols="30" rows="4" class="form-control" data-validation="required"></textarea>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">What needs to be improved?</td>
                                                    <td colspan="9">
                                                        <div class="form-group">
                                                            <textarea name="improvement" id="" cols="30" rows="4" class="form-control" data-validation="required"></textarea>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                                <td colspan="6">Login Time: {{ $scoringStart }}</td>
                                                <td colspan="5">Duration: <span id="duration"></span></td>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary btn-sm mb-3">
                                <i class="fa fa-dot-circle-o"></i> Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div><!-- .animated -->

@endsection



@section('scripts')
    <script src="{{asset('vendors/form/src/jquery.form.js')}}"></script>

    <script>
        $('#entries-sme-r1-li').addClass('active')
        $('#round1-sme-li').addClass('active')

        $(document).ready(function () {

            $('body').addClass('open')

            $('.score-input').keyup(function () {
                let total = 0

                $('.score-input').each(function (index, element) {
                    let val = $(element).val()
                    if(val !== '') {
                        val = parseFloat(val)
                    } else {
                        val = 0
                    }
                    total += val
                })

                let temp = total.toFixed(2)
                $('#total-score').text(temp)
                $('#total-score-input').val(temp)
            })

            let elapsedSeconds = 0

            setInterval(function () {
                elapsedSeconds++
                let minutes = (getQuotient(elapsedSeconds, 60)).toString()

                if(minutes.length === 1) {
                    minutes = '0' + minutes
                }

                let seconds = (elapsedSeconds % 60).toString()

                if(seconds.length === 1) {
                    seconds = '0' + seconds
                }

                $('#duration').text( minutes + " : " + seconds )
            }, 990)

            function getQuotient(number, divider) {
                return Math.floor(number/divider)
            }

            $(document).bind("contextmenu",function(e){
                return false;
            });
        })

        $.validate()
    </script>

@endsection
