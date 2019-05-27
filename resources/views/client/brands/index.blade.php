@extends('layouts.client')


@section('title', 'Brand Excellence Client Brands')

@section('breadcrumbs_title', 'Brands')

@section('breadcrumbs')
    <li class="active">Brands</li>
@endsection


@section('content')

    <div class="animated fadeIn">
        <div class="row">

            <div class="col-md-12">
                <div id="result-message"></div>
                <div class="card">
                    <div class="card-header">
                        <a class="btn btn-primary" href="{{route('brands.create')}}">Create Article <i class="fa fa-plus"></i></a>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Logo</th>
                                <th>Category</th>
                                <th>ID String</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($brands as $b)
                                    <tr>
                                        <td>{{$b->name}}</td>
                                        <td>{{$b->logo}}</td>
                                        <td>{{$b->category->name}}</td>
                                        <td>{{$b->id_string}}</td>
                                        <td></td>
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
    </script>
@endsection