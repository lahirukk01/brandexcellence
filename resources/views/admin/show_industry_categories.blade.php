
@extends('layouts.admin')

@section('title', 'Brand Excellence Admin Industry Categories')

@section('breadcrumbs_title', 'Industry Categories')

@section('breadcrumbs')
    <li class="active">Industry Categories</li>
@endsection


@section('content')

    <div class="animated fadeIn">
        <div class="row">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center">All Industry Categories</h3>
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
                            @foreach ($industryCategories as $c)
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
        $('#industry-categories-li').addClass('active')

    </script>

@endsection