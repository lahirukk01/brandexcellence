@extends('layouts.admin')

@section('title', 'Brand Excellence Judge Wise Entries SME R2')


@section('styles')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.18/b-1.5.6/b-flash-1.5.6/b-html5-1.5.6/b-print-1.5.6/r-2.2.2/datatables.css"/>

    <style>
        canvas {
            width: 100%;
            height: 400px;
        }
    </style>

@endsection


@section('breadcrumbs_title', 'SME Scores R2')

@section('breadcrumbs')
    <li><a href="{{route('admin.sme.score.judge_wise_r2')}}">Judge Wise</a></li>
    <li class="active">Judge Wise Entries</li>
@endsection


@section('content')

    <div class="animated fadeIn">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center">Judge Wise Scores R2</h3>
                        <h4>{{ $judge->name }}</h4>
                    </div>
                    <div class="card-body">
                        <table id="judge-wise-entries-table" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Entry ID</th>
                                    <th>Brand Name</th>
                                    <th>Op</th>
                                    <th>Sa</th>
                                    <th>Des</th>
                                    <th>Ta</th>
                                    <th>Dec</th>
                                    <th>Id</th>
                                    <th>POD</th>
                                    <th>Ma</th>
                                    <th>Pe</th>
                                    <th>En</th>
                                    <th>To</th>
                                    <th>View Score</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($smes as $b)
                                <tr>
                                    <td>{{ $b->id_string }}</td>
                                    <td>{{ $b->brand_name }}</td>
                                    <td>{{ $b->scoreDetails->opportunity }}</td>
                                    <td>{{ $b->scoreDetails->satisfaction }}</td>
                                    <td>{{ $b->scoreDetails->description }}</td>
                                    <td>{{ $b->scoreDetails->targeting }}</td>
                                    <td>{{ $b->scoreDetails->decision }}</td>
                                    <td>{{ $b->scoreDetails->identity }}</td>
                                    <td>{{ $b->scoreDetails->pod }}</td>
                                    <td>{{ $b->scoreDetails->marketing }}</td>
                                    <td>{{ $b->scoreDetails->performance }}</td>
                                    <td>{{ $b->scoreDetails->engagement }}</td>
                                    <td>{{ $b->scoreDetails->total }}</td>
                                    <td>
                                        <a class="btn btn-primary" href="{{ route('admin.sme.score.show_r2', ['judge' =>$judge->id, 'brand' => $b->id, 'direction' => 'judgewise']) }}">View</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tfoot>
                        </table>
                    </div>
                    <div class="card-footer">
                        <canvas id="judge-wise-graph"></canvas>
                    </div>
                </div>
            </div>


        </div>
    </div><!-- .animated -->

@endsection



@section('scripts')

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.18/b-1.5.6/b-flash-1.5.6/b-html5-1.5.6/b-print-1.5.6/r-2.2.2/datatables.js"></script>

    <script src="{{ asset('vendors/chart.js/dist/Chart.bundle.min.js') }}"></script>

    <script>
        $('#scores-sme-r2-li').addClass('active')
        $('#judge-wise-sme-r2-li > i').css('color', 'white')
        $('body').addClass('open')

        var ctx = document.getElementById( 'judge-wise-graph' );
        var myChart = new Chart( ctx, {
            type: 'bar',
            data: {
                labels: {!! $names !!},
                datasets: [
                    {
                        label: "Judge Score Graph",
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

        $('#judge-wise-entries-table').DataTable( {
            "columnDefs": [
                {
                    "orderable": false,
                }
            ],
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
        } );

    </script>

@endsection
