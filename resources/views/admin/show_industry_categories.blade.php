
@extends('layouts.admin')

@section('title', 'Brand Excellence Admin Categories')

@section('breadcrumbs_title', 'Categories')

@section('breadcrumbs')
    <li class="active">Categories</li>
@endsection


@section('content')

    <div class="animated fadeIn">
        <div class="row">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center">All Categories</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Code</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($categories as $c)
                                <tr>
                                    <td>{{$c->name}}</td>
                                    <td>{{$c->code}}</td>
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