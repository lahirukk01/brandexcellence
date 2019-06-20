
@extends('layouts.admin')

@section('title', 'Brand Excellence Admin Judge Show')


@section('styles')

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.18/r-2.2.2/sl-1.3.0/datatables.css"/>

@endsection


@section('breadcrumbs_title', 'Judges')

@section('breadcrumbs')
    <li><a href="{{route('admin.judges.index')}}">Judges</a></li>
    <li class="active">Judge</li>
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
                        <h3 class="text-center">Entries</h3>
                        <h5>{{ $judge->name }}</h5>
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
                                <th>Blocked Entries</th>
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
                                        @php
                                            $inBlocked = in_array($b->id, $blocked);
                                        @endphp

                                        <input class="allow-block-entry d-inline-block mr-1" type="checkbox"
                                               value="{{ $b->id }}" @if($inBlocked) checked @endif>
                                        <span class="d-inline-block">{{ $inBlocked ? 'Blocked':'Allowed' }}</span>
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
        $('#judges-li').addClass('active')

        $('#submit-changes').click(function () {
            let ids = []

            $('.allow-block-entry:checked').each(function (index) {
                ids.push($(this).val())
            })

            const data = {
                judgeId: '{{ $judge->id }}',
                ids,
                _token: '{{ csrf_token() }}'
            }

            $.post('{{ route('judges.set_blocked') }}', data, function (result) {

                if(result.success != undefined) {
                    alert(result.success)
                } else {
                    alert('Failed to set blocked entries for this judge')
                }
            })
        })

        // $('.delete-brand').click(function (e) {
        //     e.preventDefault()
        //     if(! confirm('Are you sure you want to delete this brand?')) {
        //         return false
        //     }
        //
        //     $(this).closest('form').submit()
        // })


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