@extends('layouts.admin')

@section('title', 'Brand Excellence Judge Wise Entries R2')


@section('styles')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.18/b-1.5.6/b-flash-1.5.6/b-html5-1.5.6/b-print-1.5.6/r-2.2.2/datatables.css"/>

    <style>

        #judge-wise-r2-li > a {
            color: white !important;
        }

        canvas {
            width: 100%;
            height: 400px;
        }
    </style>

@endsection


@section('breadcrumbs_title', 'Scores')

@section('breadcrumbs')
    <li><a href="{{route('admin.score.judge_wise')}}">Judge Wise R2</a></li>
    <li class="active">Judge Wise Entries R2</li>
@endsection


@section('content')

    <div class="animated fadeIn">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center">Judge Wise Scores R2</h3>
                        <h5>{{ $judge->name }}</h5>
                    </div>
                    <div class="card-body">
                        <table id="judge-wise-scores-table" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Entry ID</th>
                                    <th>Brand Name</th>
                                    <th>In</th>
                                    <th>Co</th>
                                    <th>Pr</th>
                                    <th>He</th>
                                    <th>Pe</th>
                                    <th>To</th>
                                    <th>View Score</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($brands as $b)
                                <tr>
                                    <td>{{ $b->id_string }}</td>
                                    <td>{{ $b->name }}</td>
                                    @if($b->category->code == 'CSR')
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    @else
                                        <th>{{ $b->scoreDetails->intent }}</th>
                                        <th>{{ $b->scoreDetails->content }}</th>
                                        <th>{{ $b->scoreDetails->process }}</th>
                                        <th>{{ $b->scoreDetails->health }}</th>
                                        <th>{{ $b->scoreDetails->performance }}</th>
                                        <th>{{ $b->scoreDetails->total }}</th>
                                    @endif
                                    <td>
                                        <a class="btn btn-primary" href="{{ route('admin.score.show2', ['judge' =>$judge->id, 'brand' => $b->id, 'direction' => 'judgewise']) }}">View</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
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
        $('#scores-r2-li').addClass('active')
        $('#judge-wise-r2-li > i').css('color', 'white')
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

        $('#judge-wise-scores-table').DataTable( {
            "columnDefs": [
                {
                    "orderable": false,
                    // "targets": 5
                }
            ],
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            // initComplete: function () {
            //     this.api().columns().every( function () {
            //         var column = this;
            //         if(column[0][0] == 2 || column[0][0] == 3) {
            //
            //             var select = $('<select style="max-width: 150px;" class="form-control"><option value=""></option></select>')
            //                 .appendTo( $(column.footer()).empty() )
            //                 .on( 'change', function () {
            //                     var val = $.fn.dataTable.util.escapeRegex(
            //                         $(this).val()
            //                     );
            //
            //                     column
            //                         .search( val ? '^'+val+'$' : '', true, false )
            //                         .draw();
            //                 } );
            //
            //             column.data().unique().sort().each( function ( d, j ) {
            //                 select.append( '<option value="'+d+'">'+d+'</option>' )
            //             } );
            //
            //         }
            //
            //     } );
            // }
        } );

    </script>

@endsection
