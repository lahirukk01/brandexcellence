@extends('layouts.admin')


@section('title', 'Brand Excellence Super User Category Edit')

@section('breadcrumbs_title', 'Categories')

@section('breadcrumbs')
    <li><a href="{{route('super.category.index')}}">Categories</a></li>
    <li class="active">Edit Category</li>
@endsection


@section('content')

    <div class="animated fadeIn">
        <div class="row">

            @if ($errors->any())
                <div class="col-md-12">
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <div class="col-md-12">
                <div id="result-message"></div>
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center">Category Details</h3>
                    </div>

                    <form method="POST" action="{{ route('super.category.update', $category->id) }}">
                        @csrf
                        @method('PATCH')
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">

                                    <div class="form-group row">
                                        <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                                        <div class="col-md-6">
                                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                                   name="name" value="{{ $category->name }}" required autocomplete="name" autofocus
                                                   data-validation="required">

                                            @error('name')
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="code" class="col-md-4 col-form-label text-md-right">{{ __('Code') }}</label>

                                        <div class="col-md-6">
                                            <input id="code" type="text" class="form-control @error('code') is-invalid @enderror"
                                                   name="code" value="{{ $category->code }}" required autocomplete="code"
                                                   data-validation="required">

                                            @error('code')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="code" class="col-md-4 col-form-label text-md-right">{{ __('Benchmark') }}</label>

                                        <div class="col-md-6">
                                            <input id="benchmark" type="text" class="form-control @error('benchmark') is-invalid @enderror"
                                                   name="benchmark" value="{{ $category->benchmark }}" required autocomplete="benchmark"
                                                   data-validation="required number">

                                            @error('benchmark')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Update Category') }}
                                    </button>
                                </div>
                            </div>
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
