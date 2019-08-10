@extends('layouts.admin')

@section('title', 'Brand Excellence Admin Auditor')

@section('styles')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.18/b-1.5.6/b-flash-1.5.6/b-html5-1.5.6/b-print-1.5.6/r-2.2.2/datatables.css"/>

@endsection

@section('breadcrumbs_title', 'Auditors')

@section('breadcrumbs')
    <li class="active">Auditors</li>
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
                        <a class="btn btn-primary" href="{{route('admin.auditor.create')}}">Create Auditor <i class="fa fa-plus"></i></a>
                    </div>
                    <div class="card-body">
                        <table id="auditors-table" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Contact Number</th>
                                <th>Panel</th>
                                <th>Action</th>
                                <th>Allowed /<br>Blocked</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($auditors as $a)
                                <tr>
                                    <td>{{ $a->name }}</td>
                                    <td>{{ $a->email }}</td>
                                    <td>{{ $a->contact_number }}</td>
                                    <td>@if($a->panels->count() != 0)
                                            @foreach($a->panels as $p)
                                                {{ $p->name . ',' }}
                                            @endforeach
                                        @else
                                        {{ 'NA' }}
                                        @endif
                                    </td>
                                    <td>
                                        <a auditor-id="{{ $a->id }}" id="" href="#" style="color: blue;" class="mr-2 show-entries">Entries</a>
                                        <a class="mx-2" style="color: green;" href="{{route('admin.auditor.edit', $a->id)}}">Edit</a>
                                        <form class="d-inline" action="{{route('admin.auditor.destroy', $a->id)}}" method="post">
                                            @csrf
                                            @method('DELETE')

                                            <a style="color: red;" href="#" class="delete-auditor mx-2">Delete</a>
                                        </form>

                                    </td>
                                    <td>
                                        @if($a->allowed)
                                            <a href="{{ route('admin.auditor.toggle_status', $a->id) }}" class="btn btn-danger">Block</a>
                                        @else
                                            <a href="{{ route('admin.auditor.toggle_status', $a->id) }}" class="btn btn-primary">Allow</a>
                                        @endif
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

    <!-- Modal -->
    <div class="modal fade" id="auditor-approved-entry-modal" tabindex="-1" role="dialog" aria-labelledby="auditorApprovedEntryModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Auditor Approved Entries</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="entry-container" class="container-fluid">
                        <div class="row">
                            <div id="entries-col" class="col-md-12">

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

@endsection



@section('scripts')

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.18/b-1.5.6/b-flash-1.5.6/b-html5-1.5.6/b-print-1.5.6/r-2.2.2/datatables.js"></script>

    <script>
        $('#auditors-li').addClass('active')

        $('.delete-auditor').click(function (e) {
            e.preventDefault()
            if(! confirm('Are you sure you want to delete this auditor?')) {
                return false
            }

            $(this).closest('form').submit()
        })

        $('.show-entries').click(function (e) {
            e.preventDefault()

            $('#entries-col').children().remove()

            const auditorId = $(this).attr('auditor-id')

            const data = {
                auditorId,
            }

            const url = '{{ route('admin.auditor.get_entries') }}'

            $.get(url, data, function (response) {
                let ulist = $('<ul></ul>')

                for( let i = 0; i < response.length; i++) {
                    let listItem = `<li>${response[i]}</li>`
                    ulist.append(listItem)
                }

                $('#entries-col').append(ulist)

                $('#auditor-approved-entry-modal').modal()
            })
        })

        $(document).ready(function() {
            $('#auditors-table').DataTable( {
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            } );
        } );

    </script>

@endsection
