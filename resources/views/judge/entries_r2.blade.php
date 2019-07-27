
@extends('layouts.judge')

@section('title', 'Brand Excellence Judge Entries R2')


@section('styles')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.18/r-2.2.2/sl-1.3.0/datatables.css"/>
@endsection


@section('breadcrumbs_title', 'Entries R2')

@section('breadcrumbs')
    <li class="active">Entries R2</li>
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
                    </div>
                    <div class="card-body">
                        <table id="judge-entries-table" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Entry ID</th>
                                    <th>Brand Name</th>
                                    <th>Category</th>
                                    <th>Industry Category</th>
                                    <th>Company</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @php
                            $numberOfScoredEntries = 0;
                            @endphp

                            @foreach ($brands as $b)
                                <tr>
                                    <td>{{ $b->id_string }}</td>
                                    <td>{{ $b->name }}</td>
                                    <td>{{ $b->category->name }}</td>
                                    <td>{{ $b->industryCategory->name }}</td>
                                    <td>{{ $b->company->name }}</td>


                                    <td>
                                    @if( $judge->finalized_r2 == false)
                                        @if ($b->judges()->whereJudgeId($judge->id)->count() == 2)
                                        <a class="mx-2 btn btn-success" href="{{route('judge.edit2', $b->id)}}">Edit</a>
                                        @else
                                        <a class="btn btn-primary" href="{{route('judge.score2', $b->id)}}">Score</a>
                                        @endif
                                    @endif
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
                        @if ($numberOfScoredEntries == $brands->count() && $judge->finalized_r2 == false)
                            <button id="finalize" num-entries="{{ $numberOfScoredEntries }}" class="btn btn-primary">Finalize R2</button>
                        @endif
                    </div>
                </div>
            </div>


        </div>
    </div><!-- .animated -->

@endsection



@section('scripts')
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.18/r-2.2.2/sl-1.3.0/datatables.js"></script>

    <script>
        $('#entries-r2-li').addClass('active')

        $('#finalize').click(function () {
            if(!confirm('Are you sure you want to finalize round 2 scoring?')) {
                return false
            }

            const numberOfEntriesFinalized = $(this).attr('num-entries')
            const url = '{{ route('judge.finalize2') }}'
            const data = {
                _token: '{{ csrf_token() }}',
                numberOfEntriesFinalized
            }

            $.post(url, data, function (result) {
                // console.log(result)
                if(result === 'success') {
                    location.reload()
                } else {
                    alert('Failed to finalize')
                }
            })
        })

        $('#judge-entries-table').DataTable( {
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
