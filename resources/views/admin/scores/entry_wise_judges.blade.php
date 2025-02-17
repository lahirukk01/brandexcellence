@extends('layouts.admin')

@section('title', 'Brand Excellence Entry Wise Judges')

@section('styles')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.18/b-1.5.6/b-flash-1.5.6/b-html5-1.5.6/b-print-1.5.6/r-2.2.2/datatables.css"/>
    <style>
        #entry-wise-r1-li > a {
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
    <li><a href="{{route('admin.score.entry_wise')}}">Entry Wise</a></li>
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
                            @foreach ($judges as $j)
                                <tr>
                                    <td>{{ $j->name }}</td>
                                    <td>{{ $j->email }}</td>
                                    @if($j->scoreDetails == null)
                                    <td>CSR</td>
                                    <td>CSR</td>
                                    <td>CSR</td>
                                    <td>CSR</td>
                                    <td>CSR</td>
                                    <td>CSR</td>
                                    @else
                                    <td>{{ $j->scoreDetails->intent }}</td>
                                    <td>{{ $j->scoreDetails->content }}</td>
                                    <td>{{ $j->scoreDetails->process }}</td>
                                    <td>{{ $j->scoreDetails->health }}</td>
                                    <td>{{ $j->scoreDetails->performance }}</td>
                                    <td>{{ $j->scoreDetails->total }}</td>
                                    @endif
                                    <td>
                                        <a class="btn btn-primary" href="{{ route('admin.score.show', ['judge' =>$j->id, 'brand' => $brand->id, 'direction' => 'entrywise']) }}">View</a>
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
        $('#scores-r1-li').addClass('active')
        $('#entry-wise-r1-li > i').css('color', 'white')

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
