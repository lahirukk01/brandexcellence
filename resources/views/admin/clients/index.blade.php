
@extends('layouts.admin')

@section('title', 'Brand Excellence Admin All Clients')

@section('styles')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.18/r-2.2.2/sl-1.3.0/datatables.css"/>
@endsection

@section('breadcrumbs_title', 'Clients')

@section('breadcrumbs')
    <li class="active">Clients</li>
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
                        <h3 class="text-center">Profiles</h3>
                    </div>
                    <div class="card-body">
                        <table id="all-clients-table" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>Company Name</th>
                                <th>Applicant Name</th>
                                <th>Email</th>
                                <th>Contact Number</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($clients as $c)
                                <tr>
                                    <td>{{$c->company->name}}</td>
                                    <td>{{$c->name}}</td>
                                    <td>{{$c->email}}</td>
                                    <td>{{ $c->contact_number }}</td>
                                    <td>
                                        <a style="color: #0e6498;" href="{{route('clients.show', $c->id)}}">View</a>
                                        <a style="color: green;" href="{{route('clients.edit', $c->id)}}">Edit</a>
                                        <form class="d-inline" action="{{route('clients.destroy', $c->id)}}" method="post">
                                            @csrf
                                            @method('DELETE')

                                            <a style="color: red;" href="#" class="delete-client">Delete</a>
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

    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.18/r-2.2.2/sl-1.3.0/datatables.js"></script>

    <script>
        $('#clients-li').addClass('active')

        $('.delete-client').click(function (e) {
            e.preventDefault()
            if(! confirm('Are you sure you want to delete this client?')) {
                return false
            }

            $(this).closest('form').submit()
        })

        $('#all-clients-table').DataTable({
            "columnDefs": [
                { "orderable": false, "targets": 4 }
            ],
        })

    </script>

@endsection