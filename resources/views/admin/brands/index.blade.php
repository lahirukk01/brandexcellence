
@extends('layouts.admin')

@section('title', 'Brand Excellence Admin Brands')

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
                        <h3 class="text-center">Brands</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>Entry ID</th>
                                <th>Brand Name</th>
                                <th>Category</th>
                                <th>Company</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($brands as $b)
                                <tr>
                                    <td>{{ $b->id_string }}</td>
                                    <td>{{ $b->name }}</td>
                                    <td>{{ $b->category->name }}</td>
                                    <td>{{ $b->company->name }}</td>
                                    <td>
                                        <a style="color: #0e6498;" href="{{route('admin.brands.show', $b->id)}}">View</a>
                                        <a class="mx-2" style="color: green;" href="{{route('admin.brands.edit', $b->id)}}">Edit</a>
                                        <form class="d-inline" action="{{route('admin.brands.destroy', $b->id)}}" method="post">
                                            @csrf
                                            @method('DELETE')

                                            <a style="color: red;" href="#" class="delete-brand">Delete</a>
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
        $('#brands-li').addClass('active')

        $('.delete-brand').click(function (e) {
            e.preventDefault()
            if(! confirm('Are you sure you want to delete this client?')) {
                return false
            }

            $(this).closest('form').submit()
        })

    </script>

@endsection