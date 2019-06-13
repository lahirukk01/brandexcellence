@extends('layouts.admin')

@section('title', 'Brand Excellence Super User Create Category')

@section('breadcrumbs_title', 'Categories')

@section('breadcrumbs')
    <li><a href="{{route('categories.index')}}">Categories</a></li>
    <li class="active">Create Category</li>
@endsection

@section('content')
    <div class="animated fadeIn">

        @if( $errors->any())
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-danger">
                    <ul>
                        @foreach( $errors->all() as $e)
                        <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        @endif

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <form id="create-brand-form" action="{{route('categories.store')}}" method="post" enctype="multipart/form-data" class="form-horizontal">
                        @csrf
                        <div class="card-header">
                            <h3 class="text-center">Create Category</h3>
                        </div>
                        <div class="card-body">
                            <h6 class="mb-3" style="color: red;">All fields are required</h6>

                            <div class="row form-group">
                                <div class="col col-md-3"><label for="name-input" class=" form-control-label">Name</label></div>
                                <div class="col-12 col-md-9">
                                    <input type="text" id="category-name-input" name="name"
                                           class="form-control" value="{{old('name')}}" data-validation="required">
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col col-md-3"><label for="code-input" class=" form-control-label">Code</label></div>
                                <div class="col-12 col-md-9">
                                    <input type="text" id="category-code-input" name="code"
                                           class="form-control" value="{{old('code')}}" data-validation="required">
                                </div>
                            </div>

                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary btn-sm mb-3">
                                <i class="fa fa-dot-circle-o"></i> Create Category
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div><!-- .animated -->
@endsection

@section('scripts')

    <script src="{{asset('vendors/form/src/jquery.form.js')}}"></script>
    <script>
        $('#categories-li').addClass('active')

        $.validate()


    </script>
@endsection