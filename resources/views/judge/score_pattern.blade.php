@extends('layouts.judge')

@section('title', 'Brand Excellence Judge Score Pattern')

@section('styles')

    <style>
        canvas {
            width: 100%;
            height: 400px;
        }

        #score-pattern-r1-li.active > i {
            color: white !important;
        }
    </style>
@endsection

@section('breadcrumbs_title', 'Score Pattern')

@section('breadcrumbs')
    <li class="active">Score Pattern</li>
@endsection



@section('content')

    <div class="animated fadeIn">
        <div class="row">
            <div class="col-md-12">
                <div id="result-message"></div>
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center">Score Pattern</h3>
                    </div>
                    <div class="card-body">

                        <canvas id="score-pattern"></canvas>

                    </div>
                    <div class="card-footer">

                    </div>
                </div>
            </div>

        </div>
    </div><!-- .animated -->

@endsection



@section('scripts')

    <script src="{{ asset('vendors/chart.js/dist/Chart.bundle.min.js') }}"></script>

    <script>
        $('#score-pattern-r1-li').addClass('active')
        $('#round1-li').addClass('active')

        // single bar chart
        var ctx = document.getElementById( "score-pattern" );
        var myChart = new Chart( ctx, {
            type: 'bar',
            data: {
                labels: {!! $names !!},
                datasets: [
                    {
                        label: "My Score Pattern",
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
