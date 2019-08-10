@extends('layouts.admin')

@section('title', 'Brand Excellence Admin SME')

@section('styles')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.18/b-1.5.6/b-flash-1.5.6/b-html5-1.5.6/b-print-1.5.6/r-2.2.2/datatables.css"/>

@endsection

@section('breadcrumbs_title', 'SME')

@section('breadcrumbs')
    <li class="active">SME</li>
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
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="card">
                    <div class="card-header">
                        <a class="btn btn-primary" href="{{route('admin.sme.create')}}">Create SME <i class="fa fa-plus"></i></a>
                    </div>
                    <div class="card-body">
                        <table id="smes-table" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Brand Name</th>
                                    <th>Company</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($smes as $s)
                                <tr>
                                    <td>{{ $s->brand_name }}</td>
                                    <td>{{ $s->company }}</td>
                                    <td>
                                        <a href="{{route('admin.sme.edit', $s->id)}}" class="text-success">Edit</a>

                                        <form class="d-inline" action="{{route('admin.sme.destroy', $s->id)}}" method="post">
                                            @csrf
                                            @method('DELETE')

                                            <a style="color: red;" href="#" class="delete-sme mx-2">Delete</a>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-sm-12">

                                <form action="{{ route('admin.sme.set_judges') }}" method="post">
                                    @csrf
                                    <h4 class="mb-3">Available Judges</h4>
                                    <div class="row">
                                        @foreach($judges as $j)
                                        <div class="checkbox col-sm-4">
                                            <label>
                                                <input class="mr-2" type="checkbox" name="judges[]"
                                                       value="{{ $j->id }}" @if($j->isSME) checked @endif>{{ $j->name }}
                                            </label>
                                        </div>
                                        @endforeach
                                    </div>
                                    <button type="submit" class="btn btn-primary mt-3">Set Judges</button>
                                </form>
                            </div>
                        </div>
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
        $('#smes-li').addClass('active')

        $('.delete-sme').click(function (e) {
            e.preventDefault()
            if(! confirm('Are you sure you want to delete this sme?')) {
                return false
            }

            $(this).closest('form').submit()
        })

        $(document).ready(function() {
            $('#smes-table').DataTable( {
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            } );
        } );

    </script>

@endsection
