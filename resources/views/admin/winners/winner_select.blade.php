
@extends('layouts.admin')

@section('title', 'Brand Excellence Admin Winner Select')

@section('styles')
    <style>
        td > span {
            width: 30px;
            height: 25px;
        }

        td > span > input {
            margin-top: 4px;
        }
    </style>
@endsection

@section('breadcrumbs_title', 'Winners')

@section('breadcrumbs')
    <li><a href="{{ route('admin.winner.index') }}">Winner Categories</a></li>
    <li class="active">Winner Select</li>
@endsection


@section('content')

    <div class="animated fadeIn">
        <div class="row">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="text-center">Select Winners</h4>
                    </div>
                    <div class="card-body">
                        <table id="passed-entries-table" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Brand Name</th>
                                    <th>Average</th>
                                    <th>Medal <br> (Gold | Silver | Bronze | Merit | None)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($brands as $b)
                                <tr brand_id="{{ $b->id }}">
                                    <td>{{ $b->name }}</td>
                                    <td>{{ $b->average }}</td>
                                    <td>
                                        <span class="d-inline-block" style="background-color: gold;">
                                            <input class="d-block mx-auto" type="radio" name="{{ 'medal' . $b->id }}" value="Gold" id="" @if($b->medal == 'Gold') checked @endif>
                                        </span>
                                        <span class="d-inline-block" style="background-color: silver;">
                                            <input class="d-block mx-auto" type="radio" name="{{ 'medal' . $b->id }}" value="Silver" id="" @if($b->medal == 'Silver') checked @endif>
                                        </span>
                                        <span class="d-inline-block" style="background-color: #cd7f32;">
                                            <input class="d-block mx-auto" type="radio" name="{{ 'medal' . $b->id }}" value="Bronze" id="" @if($b->medal == 'Bronze') checked @endif>
                                        </span>
                                        <span class="d-inline-block" style="background-color: lightblue;">
                                            <input class="d-block mx-auto" type="radio" name="{{ 'medal' . $b->id }}" value="Merit" id="" @if($b->medal == 'Merit') checked @endif>
                                        </span>
                                        <span class="d-inline-block">
                                            <input class="d-block mx-auto" type="radio" name="{{ 'medal' . $b->id }}" value="" id=""  @if($b->medal == null) checked @endif>
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        <button id="submit-result" class="btn btn-primary">Submit Changes</button>
                    </div>
                </div>
            </div>

        </div>
    </div><!-- .animated -->

@endsection



@section('scripts')

    <script>

        $('#winners-li').addClass('active')

        $('#submit-result').click(function () {
            let rows = $('tbody tr')

            let results = []

            const categoryCode = '{{ $categoryCode }}'

            rows.each(function (index) {
                let brandId = parseInt($(this).attr('brand_id'))
                let checkInput = $(this).find(`input:checked`).val()
                let temp = [brandId, checkInput]
                results.push(temp)
            })

            const data = {
                results,
                categoryCode,
                _token: '{{ csrf_token() }}'
            }

            const url = '{{ route('admin.winner.set_winners') }}'

            $.post(url, data, function (response) {
                if(response === 'success') {
                    alert('Winners set successfully')
                } else {
                    alert('Failed to set winners')
                }
            })
        })

    </script>

@endsection
