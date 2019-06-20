
@extends('layouts.admin')

@section('title', 'Brand Excellence Admin Brands')


@section('styles')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.18/r-2.2.2/sl-1.3.0/datatables.css"/>

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
                                <th>Show/Hide <br>Options
{{--                                    <div class="form-check form-check-inline">--}}
{{--                                        <input class="form-check-input" type="checkbox" id="select-all-entries" value="">--}}
{{--                                    </div>--}}
                                    <input class="d-block mx-auto" type="checkbox" id="select-all-entries" value="">
                                </th>
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
                                    <td>
{{--                                        <div class="form-check form-check-inline">--}}
{{--                                            <input class="form-check-input show-hide-options" type="checkbox" value="">--}}
{{--                                        </div>--}}

                                        <input class="show-hide-options d-inline-block mr-1" type="checkbox"
                                               value="{{ $b->id }}" {{ $b->show_options == 1 ? 'checked':null }}>
                                        <span class="d-inline-block">{{ $b->show_options == 1 ? 'Show':'Hide' }}</span>
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
                    <div class="card-footer">
                        <button id="submit-changes" class="btn btn-primary">Submit Changes</button>
                    </div>
                </div>
            </div>


        </div>
    </div><!-- .animated -->

@endsection



@section('scripts')

<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.18/r-2.2.2/sl-1.3.0/datatables.js"></script>

    <script>
        $('#brands-li').addClass('active')

        $('#select-all-entries').change(function () {
            const allEntries = this
            $('.show-hide-options').prop('checked', allEntries.checked)
        })

        $('.show-hide-options').change(function () {
            if (this.checked == false) {
                $('#select-all-entries').prop('checked', false)
            }
        })

        $('.show-hide-options').change(function () {
            if(this.checked == true) {
                $(this).siblings('span').text('Show')
            } else {
                $(this).siblings('span').text('Hide')
            }
        })

        $('#submit-changes').click(function () {
            let ids = []

            $('.show-hide-options').each(function (index) {
                ids.push([
                    $(this).val(),
                    $(this).prop('checked') ? 1:0
                ])
            })

            const data = {
                ids,
                _token: '{{ csrf_token() }}'
            }

            $.post('{{ route('admin.brands.set_options') }}', data, function (result) {
                // console.log(result)
                if(result.success != undefined) {
                    alert(result.success)
                } else {
                    alert('Failed to set client access to brands options')
                }
            })
        })


        $('.delete-brand').click(function (e) {
            e.preventDefault()
            if(! confirm('Are you sure you want to delete this brand?')) {
                return false
            }

            $(this).closest('form').submit()
        })


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