@extends('layouts.admin')

@section('title', 'Brand Excellence Admin Judges')

@section('styles')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.18/b-1.5.6/b-flash-1.5.6/b-html5-1.5.6/b-print-1.5.6/r-2.2.2/datatables.css"/>

@endsection

@section('breadcrumbs_title', 'Judges')

@section('breadcrumbs')
    <li class="active">Judges</li>
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
                        <a class="btn btn-primary" href="{{route('admin.judge.create')}}">Create Judge <i class="fa fa-plus"></i></a>
                    </div>
                    <div class="card-body">
                        <table id="judges-table" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Action</th>
                                <th>Finalized</th>
                                <th>Allowed /<br>Blocked</th>
                                <th>Online<br>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($judges as $j)
                                <tr>
                                    <td>{{ $j->name }}</td>
                                    <td>{{ $j->email }}</td>
                                    <td>
                                        <a style="color: #0e6498;" href="{{route('admin.judge.show', $j->id)}}">View</a>
                                        <a class="mx-2" style="color: green;" href="{{route('admin.judge.edit', $j->id)}}">Edit</a>
                                        <form class="d-inline" action="{{route('admin.judge.destroy', $j->id)}}" method="post">
                                            @csrf
                                            @method('DELETE')

                                            <a style="color: red;" href="#" class="delete-judge mx-2">Delete</a>
                                        </form>

                                    </td>
                                    <td><button id="{{ $j->id }}" class="btn btn-info unlock-btn" @if($j->finalized == false) disabled @endif>Un-Finalize</button></td>
                                    <td>
                                        @if($j->allowed)
                                            <a href="{{ route('admin.judge.toggle_status', $j->id) }}" class="btn btn-danger">Block</a>
                                        @else
                                            <a href="{{ route('admin.judge.toggle_status', $j->id) }}" class="btn btn-primary">Allow</a>
                                        @endif
                                    </td>
                                    <td>
                                        @if($j->isOnline())
                                            <span class="text-success">Online</span>
                                        @else
                                            <span class="text-danger">Offline</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-sm-12">
                                <a href="{{ route('admin.judge.allow_all_judges') }}" class="btn btn-primary d-inline-block">Allow All</a>
                                <a href="{{ route('admin.judge.block_all_judges') }}" class="btn btn-danger d-inline-block">Block All</a>
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
        $('#judges-li').addClass('active')

        setInterval(function() {
            location.reload()
        }, 60000)

        $('.unlock-btn').click(function () {
            const judgeId = $(this).prop('id')

            const url = '{{ route('admin.judge.unlock') }}'

            const data = {
                judgeId,
                _token: '{{ csrf_token() }}'
            }

            $.post(url, data, function (result) {
                // console.log(result)
                if(result === 'success') {
                    location.reload()
                } else {
                    alert('Failed to un-finalize judge scoring')
                }
            })
        })

        $('.delete-judge').click(function (e) {
            e.preventDefault()
            if(! confirm('Are you sure you want to delete this judge?')) {
                return false
            }

            $(this).closest('form').submit()
        })

        $(document).ready(function() {
            $('#judges-table').DataTable( {
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            } );
        } );

    </script>

@endsection
