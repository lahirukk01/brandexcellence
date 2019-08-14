@extends('layouts.admin')

@section('title', 'Brand Excellence Admin Entry Wise SME Scores')


@section('styles')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.18/b-1.5.6/b-flash-1.5.6/b-html5-1.5.6/b-print-1.5.6/r-2.2.2/datatables.css"/>

<style>
    #entry-wise-sme-r1-li > a {
        color: white !important;
    }
</style>

@endsection


@section('breadcrumbs_title', 'SME Scores R1')

@section('breadcrumbs')
    <li class="active">Entry Wise</li>
@endsection


@section('content')

    <div class="animated fadeIn">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center">Entry Wise Scores R1</h3>
                    </div>
                    <div class="card-body">
                        <table id="admin-brands-table" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Entry ID</th>
                                    <th>Brand Name</th>
                                    <th>Company</th>
                                    <th>Average</th>
                                    <th>View Scores</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($smes as $b)
                                <tr>
                                    <td>{{ $b->id_string }}</td>
                                    <td>{{ $b->brand_name }}</td>
                                    <td>{{ $b->company }}</td>
                                    <td>{{ $b->average }}</td>
                                    <td>
                                        <a class="btn btn-primary" href="{{route('admin.sme.score.entry_wise_judges', $b->id)}}">View</a>
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
                            </tfoot>
                        </table>
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

    <script>
        $('#scores-sme-r1-li').addClass('active')
        $('#entry-wise-sme-r1-li > i').css('color', 'white')

        $('#admin-brands-table').DataTable( {
            "columnDefs": [
                { "orderable": false, }
            ],
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],

        } );

    </script>

@endsection
