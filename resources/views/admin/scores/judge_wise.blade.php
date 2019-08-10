@extends('layouts.admin')

@section('title', 'Brand Excellence Admin Judge Wise Scores')

@section('breadcrumbs_title', 'Scores')

@section('styles')
    <style>
        #judge-wise-r1-li > a {
            color: white !important;
        }
    </style>
@endsection

@section('breadcrumbs')
    <li class="active">Judge Wise</li>
@endsection


@section('content')

    <div class="animated fadeIn">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center">Judge Wise Scores</h3>
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
                                        <a class="btn btn-primary" href="{{route('admin.score.judge_wise_entries', $j->id)}}">View</a>
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
        $('#scores-r1-li').addClass('active')
        $('#judge-wise-r1-li > i').css('color', 'white')

    </script>

@endsection
