@extends('layouts.admin')

@section('title', 'Brand Excellence Admin Entry Wise Scores')


@section('styles')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.18/r-2.2.2/sl-1.3.0/datatables.css"/>

@endsection


@section('breadcrumbs_title', 'Scores')

@section('breadcrumbs')
    <li class="active">Entry Wise</li>
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
                        <table id="admin-brands-table" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Entry ID</th>
                                    <th>Brand Name</th>
                                    <th>Category</th>
                                    <th>Industry Category</th>
                                    <th>Company</th>
                                    <th>View Scores</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($brands as $b)
                                <tr>
                                    <td>{{ $b->id_string }}</td>
                                    <td>{{ $b->name }}</td>
                                    <td>{{ $b->category->name }}</td>
                                    <td>{{ $b->industryCategory->name }}</td>
                                    <td>{{ $b->company->name }}</td>
                                    <td>
                                        <a class="btn btn-primary" href="{{route('scores.entryWiseJudges', $b->id)}}">View</a>
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
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>


        </div>
    </div><!-- .animated -->

@endsection



@section('scripts')

<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.18/r-2.2.2/sl-1.3.0/datatables.js"></script>

    <script>
        $('#scores-li').addClass('active')
        $('#entry-wise-li > i').css('color', 'white')


        $('#admin-brands-table').DataTable( {
            "columnDefs": [
                { "orderable": false, "targets": 5 }
            ],
            initComplete: function () {
                this.api().columns().every( function () {
                    var column = this;
                    if(column[0][0] == 2 || column[0][0] == 3) {

                        var select = $('<select style="max-width: 150px;" class="form-control"><option value=""></option></select>')
                            .appendTo( $(column.footer()).empty() )
                            .on( 'change', function () {
                                var val = $.fn.dataTable.util.escapeRegex(
                                    $(this).val()
                                );

                                column
                                    .search( val ? '^'+val+'$' : '', true, false )
                                    .draw();
                            } );

                        column.data().unique().sort().each( function ( d, j ) {
                            select.append( '<option value="'+d+'">'+d+'</option>' )
                        } );

                    }

                } );
            }
        } );

    </script>

@endsection