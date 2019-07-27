@extends('layouts.admin')

@section('title', 'Brand Excellence Admin Judges')

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
                        <table class="table table-striped table-bordered">
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

@endsection



@section('scripts')

    <script>
        $('#auditors-li').addClass('active')

        $('.delete-auditor').click(function (e) {
            e.preventDefault()
            if(! confirm('Are you sure you want to delete this auditor?')) {
                return false
            }

            $(this).closest('form').submit()
        })

    </script>

@endsection
