@extends('layouts.admin')

@section('title', 'Brand Excellence Entry Wise Judges R1')

@section('styles')

    <style>
        #entry-wise-sme-r1-li > a {
            color: white !important;
        }

        canvas {
            width: 100%;
            height: 400px;
        }
    </style>

@endsection

@section('breadcrumbs_title', 'SME Scores R1')

@section('breadcrumbs')
    <li><a href="{{route('admin.sme.score.entry_wise')}}">Entry Wise</a></li>
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
                                        <a class="btn btn-primary" href="{{ route('admin.sme.score.show', ['judge' =>$j->id, 'sme' => $sme->id, 'direction' => 'entrywise']) }}">View</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        <canvas id="entry-wise-graph"></canvas>
                    </div>
                </div>
            </div>


        </div>
    </div><!-- .animated -->

@endsection



@section('scripts')
    <script src="{{ asset('vendors/chart.js/dist/Chart.bundle.min.js') }}"></script>

    <script>
        $('#scores-sme-r1-li').addClass('active')
        $('#entry-wise-sme-r1-li > i').css('color', 'white')

        var ctx = document.getElementById( 'entry-wise-graph' );
        var myChart = new Chart( ctx, {
            type: 'bar',
            data: {
                labels: {!! $names !!},
                datasets: [
                    {
                        label: "Entry Score Graph",
                        data: {!! $scores !!},
                        borderColor: "rgba(0, 123, 255, 0.9)",
                        borderWidth: "0",
                        backgroundColor: "rgba(0, 123, 255, 0.5)"
                    }
                ]
            },
            options: {
                scales: {
                    yAxes: [ {
                        ticks: {
                            beginAtZero: true
                        }
                    } ]
                }
            }
        } );

    </script>

@endsection
