@extends('layouts.admin')

@section('title', 'Brand Excellence Admin Panels')

@section('styles')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.18/b-1.5.6/b-flash-1.5.6/b-html5-1.5.6/b-print-1.5.6/r-2.2.2/datatables.css"/>

@endsection

@section('breadcrumbs_title', 'Panels')

@section('breadcrumbs')
    <li class="active">Panels</li>
@endsection


@section('content')

    <div class="animated fadeIn">
        <div class="row">
            @if (session('status'))
                <div class="alert alert-success alert-dismissible fade show floating-response" role="alert">
                    {{ session('status') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <a class="btn btn-primary" href="{{route('admin.panel.create')}}">Create Panel <i class="fa fa-plus"></i></a>
                    </div>
                    <div class="card-body">
                        <table id="panels-table" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Auditor</th>
                                <th># Judges</th>
                                <th># Categories</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($panels as $p)
                                <tr>
                                    <td>{{ $p->name }}</td>
                                    <td>{{ $p->auditor->name }}</td>
                                    <td>{{ $p->judges->count() }}</td>
                                    <td>{{ $p->categories->count() }}</td>
                                    <td>
                                        <a style="color: #0e6498;" href="{{route('admin.panel.show', $p->id)}}">View</a>
                                        <a class="mx-2" style="color: green;" href="{{route('admin.panel.edit', $p->id)}}">Edit</a>
                                        <form class="d-inline" action="{{route('admin.panel.destroy', $p->id)}}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <a style="color: red;" href="#" class="delete-panel mx-2">Delete</a>
                                        </form>
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

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.18/b-1.5.6/b-flash-1.5.6/b-html5-1.5.6/b-print-1.5.6/r-2.2.2/datatables.js"></script>

    <script>
        $('#panels-li').addClass('active')

        $('.delete-panel').click(function (e) {
            e.preventDefault()
            if(! confirm('Are you sure you want to delete this panel?')) {
                return false
            }

            $(this).closest('form').submit()
        })

        $(document).ready(function() {
            $('#panels-table').DataTable( {
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            } );
        } );

    </script>

@endsection
