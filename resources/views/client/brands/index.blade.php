@extends('layouts.client')


@section('title', 'Brand Excellence Client Brands')

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
                        <a class="btn btn-primary" href="{{route('brands.create')}}">Create Brand <i class="fa fa-plus"></i></a>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Category</th>
                                <th>ID</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($brands as $b)
                                    <tr>
                                        <td>{{$b->name}}</td>
                                        <td>{{$b->category->name}}</td>
                                        <td>{{$b->id_string}}</td>
                                        <td>
                                            <a style="color: #0e6498;" href="{{route('brands.show', $b->id)}}">View</a>

                                            @if ($b->show_options == 1)
                                            <a class="mx-2" style="color: green;" href="{{route('brands.edit', $b->id)}}">Edit</a>
                                            <form class="d-inline" action="{{route('brands.destroy', $b->id)}}" method="post">
                                                @csrf
                                                @method('DELETE')

                                                <a style="color: red;" href="#" class="delete-brand">Delete</a>
                                            </form>
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
        $('#brands-li').addClass('active')

        $('.delete-brand').click(function (e) {
            e.preventDefault()
            if(! confirm('Are you sure you want to delete this brand?')) {
                return false
            }

            $(this).closest('form').submit()
        })


    </script>
@endsection