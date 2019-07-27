@extends('layouts.admin')

@section('title', 'Brand Excellence Super User Create Industry Category')

@section('breadcrumbs_title', 'Industry Categories')

@section('breadcrumbs')
    <li><a href="{{route('industry_categories.index')}}">Industry Categories</a></li>
    <li class="active">Create Industry Category</li>
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
                    <form id="create-brand-form" action="{{route('industry_categories.store')}}" method="post" enctype="multipart/form-data" class="form-horizontal">
                        @csrf
                        <div class="card-header">
                            <h3 class="text-center">Create Industry Category</h3>
                        </div>
                        <div class="card-body">
                            <h6 class="mb-3" style="color: red;">All fields are required</h6>

                            <div class="row form-group">
                                <div class="col col-md-3"><label for="name-input" class=" form-control-label">Name <sup style="color: red;">*</sup></label></div>
                                <div class="col-12 col-md-9">
                                    <input type="text" id="category-name-input" name="name"
                                           class="form-control" value="{{old('name')}}" data-validation="required">
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col col-md-3"><label for="code-input" class=" form-control-label">Code <sup style="color: red;">*</sup></label></div>
                                <div class="col-12 col-md-9">
                                    <input type="text" id="category-code-input" name="code"
                                           class="form-control" value="{{old('code')}}" data-validation="required">
                                </div>
                            </div>

                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary btn-sm mb-3">
                                <i class="fa fa-dot-circle-o"></i> Create Industry Category
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
        $('#industry-categories-li').addClass('active')

        $.validate()


    </script>
@endsection