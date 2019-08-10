
@extends('layouts.judge')

@section('title', 'Brand Excellence Judge SME Entries R1')


@section('styles')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.18/r-2.2.2/sl-1.3.0/datatables.css"/>

    <style>
        #entries-sme-r1-li.active > i {
            color: white !important;
        }

    </style>
@endsection


@section('breadcrumbs_title', 'SME Entries R1')

@section('breadcrumbs')
    <li class="active">SME Entries R1</li>
@endsection


@section('content')

    <div class="animated fadeIn">
        @if( $errors->any())
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-danger">
                    <ul>
                        @foreach( $errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        @endif
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
                        <h3 class="text-center">SME Entries R1</h3>
                    </div>
                    <div class="card-body">
                        <table id="judge-entries-table" class="table table-striped table-bordered">
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
                                        @if( !$b->judge_has_finalized )
                                            @if ($b->judge_has_scored)
                                                <a class="mx-2 btn btn-success" href="{{route('judge.sme.edit_r1', $b->id)}}">Edit</a>
                                            @else
                                                <a class="btn btn-primary" href="{{route('judge.sme.score_r1', $b->id)}}">Score</a>
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
                            </tfoot>
                        </table>
                    </div>
                    <div class="card-footer">
                        @if ($judgeHasScoredAll)
                            <button id="finalize" class="btn btn-primary">Finalize</button>
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
        $('#entries-sme-r1-li').addClass('active')
        $('#round1-sme-li').addClass('active')

        $('#finalize').click(function () {

            const brandsToBeFinalized = {{ $brandsToBeFinalized }}

            if( brandsToBeFinalized.length === 0) {
                alert('There are no entries to be finalized')
                return false
            }

            if(!confirm('Are you sure you want to finalize scoring?')) {
                return false
            }

            let finalize = $(this)

            $(this).prop('disabled', true)

            const url = '{{ route('judge.sme.finalize_r1') }}'
            const data = {
                _token: '{{ csrf_token() }}',
                brandsToBeFinalized
            }

            $.post(url, data, function (result) {
                finalize.prop('disabled', false)
                if(result === 'success') {
                    alert('success')
                } else {
                    alert('Failed to finalize')
                }
            })
        })

        $('#judge-entries-table').DataTable( {
            // "columnDefs": [
            //     { "orderable": false, "targets": 5 }
            // ],
        } );

    </script>

@endsection
