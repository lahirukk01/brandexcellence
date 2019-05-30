
@extends('layouts.admin')

@section('title', 'Brand Excellence Admin Brands')


@section('styles')
{{--    <link rel="stylesheet" href="{{asset('vendors/datatables.net/css/jquery.dataTables.css')}}">--}}
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
@endsection


@section('breadcrumbs_title', 'Brands')

@section('breadcrumbs')
    <li class="active">Brands</li>
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
                        <h3 class="text-center">Brands</h3>
                    </div>
                    <div class="card-body">
                        <table id="admin-brands-table" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>Entry ID</th>
                                <th>Brand Name</th>
                                <th>Category</th>
                                <th>Company</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($brands as $b)
                                <tr>
                                    <td>{{ $b->id_string }}</td>
                                    <td>{{ $b->name }}</td>
                                    <td>{{ $b->category->name }}</td>
                                    <td>{{ $b->company->name }}</td>
                                    <td>
                                        <a style="color: #0e6498;" href="{{route('admin.brands.show', $b->id)}}">View</a>
                                        <a class="mx-2" style="color: green;" href="{{route('admin.brands.edit', $b->id)}}">Edit</a>
                                        <form class="d-inline" action="{{route('admin.brands.destroy', $b->id)}}" method="post">
                                            @csrf
                                            @method('DELETE')

                                            <a style="color: red;" href="#" class="delete-brand">Delete</a>
                                        </form>

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
                    <div class="card-footer">

                    </div>
                </div>
            </div>


        </div>
    </div><!-- .animated -->

@endsection



@section('scripts')

{{--    <script src="{{asset('vendors/datatables.net/js/jquery.dataTables.js')}}"></script>--}}
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>

    <script>
        $('#brands-li').addClass('active')

        $('.delete-brand').click(function (e) {
            e.preventDefault()
            if(! confirm('Are you sure you want to delete this brand?')) {
                return false
            }

            $(this).closest('form').submit()
        })


        $('#admin-brands-table').DataTable( {
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