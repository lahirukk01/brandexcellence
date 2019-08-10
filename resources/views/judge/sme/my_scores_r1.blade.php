
@extends('layouts.judge')

@section('title', 'Brand Excellence Judge SME Scores')


@section('styles')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.18/r-2.2.2/sl-1.3.0/datatables.css"/>

    <style>
        #my-scores-sme-r1-li.active > i {
            color: white !important;
        }
    </style>
@endsection


@section('breadcrumbs_title', 'My SME Scores')

@section('breadcrumbs')
    <li class="active">My SME Scores</li>
@endsection


@section('content')

    <div class="animated fadeIn">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center">Scored Entries</h3>
                    </div>
                    <div class="card-body">
                        <table id="judge-scored-entries-table" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Entry ID</th>
                                    <th>Brand Name</th>
                                    <th>Company</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($smes as $b)
                                <tr>
                                    <td>{{ $b->id_string }}</td>
                                    <td>{{ $b->brand_name }}</td>
                                    <td>{{ $b->company }}</td>
                                    <td>
                                        <a class="mx-2 btn btn-primary" href="{{route('judge.sme.show_score_r1', $b->id)}}">View</a>
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
                </div>
            </div>
        </div>
    </div><!-- .animated -->

@endsection



@section('scripts')
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.18/r-2.2.2/sl-1.3.0/datatables.js"></script>

    <script>
        $('#my-scores-sme-r1-li').addClass('active')
        $('#round1-sme-li').addClass('active')

        $('#judge-scored-entries-table').DataTable( {
            // "columnDefs": [
            //     { "orderable": false, "targets": 5 }
            // ],

        } );

    </script>

@endsection
