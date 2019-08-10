@extends('layouts.admin')

@section('title', 'Brand Excellence Admin Judge Wise Scores R2')

@section('styles')
    <style>
        #judge-wise-r2-li > a {
            color: white !important;
        }
    </style>
@endsection

@section('breadcrumbs_title', 'Scores R2')

@section('breadcrumbs')
    <li class="active">Judge Wise R2</li>
@endsection


@section('content')

    <div class="animated fadeIn">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center">Judge Wise Scores R2</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Average</th>
                                <th>View Scores</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($judges as $j)
                                <tr>
                                    <td>{{ $j->name }}</td>
                                    <td>{{ $j->email }}</td>
                                    <td>{{ $j->average }}</td>
                                    <td>
                                        <a class="btn btn-primary" href="{{route('admin.score.judge_wise_entries2', $j->id)}}">View</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
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
        $('#judge-wise-r2-li > i').css('color', 'white')

    </script>

@endsection
