@extends('layouts.admin')

@section('title', 'Brand Excellence Entry Wise Judges')

@section('breadcrumbs_title', 'Scores')

@section('breadcrumbs')
    <li><a href="{{route('scores.entryWise')}}">Entry Wise</a></li>
    <li class="active">Entry Wise Judges</li>
@endsection


@section('content')

    <div class="animated fadeIn">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center">Entry Wise Scores</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Telephone</th>
                                <th>View Score</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($judges as $j)
                                <tr>
                                    <td>{{ $j->name }}</td>
                                    <td>{{ $j->email }}</td>
                                    <td>{{ $j->telephone }}</td>
                                    <td>
                                        <a class="btn btn-primary" href="{{ route('scores.show', ['judge' =>$j->id, 'brand' => $brand->id, 'direction' => 'entrywise']) }}">View</a>
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
        $('#scores-li').addClass('active')
        $('#entry-wise-li > i').css('color', 'white')

    </script>

@endsection