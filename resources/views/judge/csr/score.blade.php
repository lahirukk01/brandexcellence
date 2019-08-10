@extends('layouts.judge')

@section('title', 'Brand Excellence Judge Score CSR Entry')

@section('styles')
    <style>
        .score-input {
            width: 100%;
        }

    </style>
@endsection

@section('breadcrumbs_title', 'Dashboard')

@section('breadcrumbs')
    <li><a href="{{route('judge.index')}}">Entries</a></li>
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
                    <form action="{{ route('judge.store_csr', $brand->id) }}" method="post">
                        @csrf
                        <div class="card-body">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md-3">Judge Name: {{ Auth::user()->name }}</div>
                                    <div class="col-md-2">Entry ID: {{ $brand->id_string }}</div>
                                    <div class="col-md-2">Brand: {{ $brand->name }}</div>
                                    <div class="col-md-2">Round 1</div>
                                    <div class="col-md-3">Entry Category: {{ $brand->category->name }}</div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <p>{{ $brand->description }}</p>
                                    </div>
                                </div>
                            </div>
                            <hr>

                            @if($brand->supporting_material)
                            <a class="btn btn-primary" target="_blank" href="{{ asset($brand->supporting_material) }}">Supporting Material</a>
                            @endif

                            <embed src="{{ asset($brand->entry_kit) }}#toolbar=0" width="100%" height="400">
                            <div class="row">
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
                                                    <td>
                                                        <input class="score-input" type="number" name="intent" id=""
                                                               min="0" max="10" required data-validation="required number" step="0.01"
                                                               data-validation-allowing="float range[0;10]">
                                                    </td>
                                                    <td>
                                                        <input class="score-input" type="number" name="recipient" id="" min="0" max="5"
                                                               required data-validation="required number" step="0.01"
                                                               data-validation-allowing="float range[0;5]">
                                                    </td>
                                                    <td>
                                                        <input class="score-input" type="number" name="purpose" id="" min="0" max="10"
                                                               required data-validation="required number" step="0.01"
                                                               data-validation-allowing="float range[0;10]">
                                                    </td>
                                                    <td>
                                                        <input class="score-input" type="number" name="vision" id="" min="0" max="5"
                                                               required data-validation="required number" step="0.01"
                                                               data-validation-allowing="float range[0;5]">
                                                    </td>
                                                    <td>
                                                        <input class="score-input" type="number" name="mission" id="" min="0" max="5"
                                                               required data-validation="required number" step="0.01"
                                                               data-validation-allowing="float range[0;5]">
                                                    </td>
                                                    <td>
                                                        <input class="score-input" type="number" name="identity" id="" min="0" max="10"
                                                               required data-validation="required number" step="0.01"
                                                               data-validation-allowing="float range[0;10]">
                                                    </td>
                                                    <td>
                                                        <input class="score-input" type="number" name="strategic" id="" min="0" max="25"
                                                               required data-validation="required number" step="0.01"
                                                               data-validation-allowing="float range[0;25]">
                                                    </td>
                                                    <td>
                                                        <input class="score-input" type="number" name="activities" id="" min="0" max="15"
                                                               required data-validation="required number" step="0.01"
                                                               data-validation-allowing="float range[0;15]">
                                                    </td>
                                                    <td>
                                                        <input class="score-input" type="number" name="communication" id="" min="0" max="7"
                                                               required data-validation="required number" step="0.01"
                                                               data-validation-allowing="float range[0;7]">
                                                    </td>
                                                    <td>
                                                        <input class="score-input" type="number" name="internal" id="" min="0" max="8"
                                                               required data-validation="required number" step="0.01"
                                                               data-validation-allowing="float range[0;8]">
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
        $('#entries-r1-li').addClass('active')

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
        })

        $.validate()
    </script>

@endsection
