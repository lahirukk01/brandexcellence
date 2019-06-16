@extends('layouts.judge')

@section('title', 'Brand Excellence Judge Score Entry')

@section('styles')
    <style>
        .score-input {
            width: 100%;
        }

        iframe {
            width: 100%;
            height: 500px;
        }
    </style>
@endsection

@section('breadcrumbs_title', 'Dashboard')

@section('breadcrumbs')
    <li><a href="{{route('judge.index')}}">Dashboard</a></li>
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
                    <form action="{{ route('judge.store', $brand->id) }}" method="post">
                        @csrf
                        <div class="card-header">
                            <h3 class="text-center">Score Entry</h3>
                        </div>
                        <div class="card-body">
{{--                            <a href="{{ asset($brand->entry_kit) }}" class="embed">View Entry Kit</a>--}}
                            <a href="http://www.africau.edu/images/default/sample.pdf" class="embed"></a>
                            <a class="btn btn-primary" href="{{ asset($brand->logo) }}" download>Download Brand Logo</a>
                            <hr>
                            <div class="row">
                                <div class="col-md-3">Judge Name: {{ Auth::user()->name }}</div>
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
                                                    <td>
                                                        <input class="score-input" type="number" name="intent" id=""
                                                               min="0" max="15" required data-validation="required number"
                                                               data-validation-allowing="range[0;15]">
                                                    </td>
                                                    <td>
                                                        <input class="score-input" type="number" name="content" id="" min="0" max="15" required data-validation="required number"
                                                               data-validation-allowing="range[0;15]">
                                                    </td>
                                                    <td>
                                                        <input class="score-input" type="number" name="process" id="" min="0" max="40" required data-validation="required number"
                                                               data-validation-allowing="range[0;40]">
                                                    </td>
                                                    <td>
                                                        <input class="score-input" type="number" name="health" id="" min="0" max="18" required data-validation="required number"
                                                               data-validation-allowing="range[0;18]">
                                                    </td>
                                                    <td><input class="score-input" type="number" name="performance" id="" min="0" max="12" required data-validation="required number"
                                                               data-validation-allowing="range[0;12]"></td>
                                                    <td class="text-center">
                                                        <span id="total-score"></span>
                                                        <input type="hidden" name="total" id="total-score-input">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6">Comments:</td>
                                                </tr>
                                                <tr>
                                                    <td>What is good?</td>
                                                    <td colspan="5">
                                                        <div class="form-group">
                                                            <textarea name="good" id="" cols="30" rows="4" class="form-control"></textarea>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>What is bad?</td>
                                                    <td colspan="5">
                                                        <div class="form-group">
                                                            <textarea name="bad" id="" cols="30" rows="4" class="form-control"></textarea>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>What needs to be improved?</td>
                                                    <td colspan="5">
                                                        <div class="form-group">
                                                            <textarea name="improvement" id="" cols="30" rows="4" class="form-control"></textarea>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                                <td colspan="3">Login Time: {{ \Carbon\Carbon::now() }}</td>
                                                <td colspan="3">Duration: <span id="duration"></span></td>
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
    <script src="{{ asset('vendors/jquery.gdocviewer/jquery.gdocsviewer.min.js') }}"></script>

    <script>
        $('#dashboard-li').addClass('active')

        $(document).ready(function () {

            $('a.embed').gdocsViewer();
            
            $('.score-input').change(function () {
                let total = 0
                
                $('.score-input').each(function (index, element) {
                    let val = $(element).val()
                    if(val != '') {
                        val = parseInt(val)
                    } else {
                        val = 0
                    }
                    total += val
                })

                $('#total-score').text(total)
                $('#total-score-input').val(total)
            })
            
            let elapsedSeconds = 0

            setInterval(function () {
                elapsedSeconds++
                let minutes = (getQuotient(elapsedSeconds, 60)).toString()

                if(minutes.length == 1) {
                    minutes = '0' + minutes
                }


                let seconds = (elapsedSeconds % 60).toString()

                if(seconds.length == 1) {
                    seconds = '0' + seconds
                }

                $('#duration').text( minutes + " : " + seconds )
            }, 990)

            function getQuotient(number, divider) {
                return Math.floor(number/divider)
            }
        })

        $.validate()
    </script>

@endsection