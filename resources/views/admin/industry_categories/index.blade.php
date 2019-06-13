
@extends('layouts.admin')

@section('title', 'Brand Excellence Admin Dashboard')

@section('breadcrumbs_title', 'Categories')

@section('breadcrumbs')
    <li class="active">Categories</li>
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
                        <a class="btn btn-primary" href="{{route('categories.create')}}">Create Category <i class="fa fa-plus"></i></a>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Code</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($categories as $c)
                                <tr>
                                    <td>{{$c->name}}</td>
                                    <td>{{$c->code}}</td>
                                    <td>
{{--                                        <a style="color: #0e6498;" href="{{route('categories.show', $c->id)}}">View</a>--}}
                                        <a class="mx-2" style="color: green;" href="{{route('categories.edit', $c->id)}}">Edit</a>
                                        <form class="d-inline" action="{{route('categories.destroy', $c->id)}}" method="post">
                                            @csrf
                                            @method('DELETE')

                                            <a style="color: red;" href="#" class="delete-category mx-2">Delete</a>
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
        $('#categories-li').addClass('active')

        $('.delete-category').click(function (e) {
            e.preventDefault()
            if(! confirm('Are you sure you want to delete this category?')) {
                return false
            }

            $(this).closest('form').submit()
        })

    </script>

@endsection