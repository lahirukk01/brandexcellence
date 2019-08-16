@extends('layouts.admin')

@section('title', 'Brand Excellence Entry Wise Judges R2')

@section('styles')

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.18/b-1.5.6/b-flash-1.5.6/b-html5-1.5.6/b-print-1.5.6/r-2.2.2/datatables.css"/>
    <style>
        #entry-wise-sme-r2-li > a {
            color: white !important;
        }

        canvas {
            width: 100%;
            height: 400px;
        }
    </style>

@endsection

@section('breadcrumbs_title', 'SME Scores R2')

@section('breadcrumbs')
    <li><a href="{{route('admin.sme.score.entry_wise_r2')}}">Entry Wise</a></li>
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
                        <table id="entry-wise-scores-table" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
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
                            @foreach ($judges as $j)
                                <tr>
                                    <td>{{ $j->name }}</td>
                                    <td>{{ $j->email }}</td>
                                    <td>{{ $j->scoreDetails->opportunity }}</td>
                                    <td>{{ $j->scoreDetails->satisfaction }}</td>
                                    <td>{{ $j->scoreDetails->description }}</td>
                                    <td>{{ $j->scoreDetails->targeting }}</td>
                                    <td>{{ $j->scoreDetails->decision }}</td>
                                    <td>{{ $j->scoreDetails->identity }}</td>
                                    <td>{{ $j->scoreDetails->pod }}</td>
                                    <td>{{ $j->scoreDetails->marketing }}</td>
                                    <td>{{ $j->scoreDetails->performance }}</td>
                                    <td>{{ $j->scoreDetails->engagement }}</td>
                                    <td>{{ $j->scoreDetails->total }}</td>
                                    <td>
                                        <a class="btn btn-primary" href="{{ route('admin.sme.score.show_r2', ['judge' =>$j->id, 'sme' => $sme->id, 'direction' => 'entrywise']) }}">View</a>
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
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.18/b-1.5.6/b-flash-1.5.6/b-html5-1.5.6/b-print-1.5.6/r-2.2.2/datatables.js"></script>

    <script>
        $('#scores-sme-r2-li').addClass('active')
        $('#entry-wise-sme-r2-li > i').css('color', 'white')
        $('body').addClass('open')

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

        $('#entry-wise-scores-table').DataTable( {
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
