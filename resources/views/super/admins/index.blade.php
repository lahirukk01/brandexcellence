
@extends('layouts.admin')

@section('title', 'Brand Excellence Administrators')

@section('breadcrumbs_title', 'Administrators')

@section('breadcrumbs')
    <li class="active">Administrators</li>
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
                        <a class="btn btn-primary" href="{{route('super.admin.create')}}">Create Admin <i class="fa fa-plus"></i></a>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Contact</th>
                                <th>Designation</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($admins as $a)
                                <tr>
                                    <td>{{ $a->name }}</td>
                                    <td>{{ $a->email }}</td>
                                    <td>{{ $a->contact_number }}</td>
                                    <td>{{ $a->designation }}</td>
                                    <td>{{ $a->created_at }}</td>
                                    <td>
{{--                                        <a style="color: #0e6498;" href="{{route('clients.show', $a->id)}}">View</a>--}}
                                        <a class="mr-2" style="color: green;" href="{{route('super.admin.edit', $a->id)}}">Edit</a>
                                        <form class="d-inline" action="{{route('super.admin.destroy', $a->id)}}" method="post">
                                            @csrf
                                            @method('DELETE')

                                            <a style="color: red;" href="#" class="delete-admin">Delete</a>
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

    <script>
        $('#admins-li').addClass('active')

        $('.delete-admin').click(function (e) {
            e.preventDefault()
            if(! confirm('Are you sure you want to delete this administrator?')) {
                return false
            }

            $(this).closest('form').submit()
        })

    </script>

@endsection