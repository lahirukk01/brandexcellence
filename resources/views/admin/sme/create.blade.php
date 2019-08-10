@extends('layouts.admin')

@section('title', 'Brand Excellence Admin Create SME')

@section('breadcrumbs_title', 'SME')

@section('breadcrumbs')
    <li><a href="{{route('admin.sme.index')}}">SME</a></li>
    <li class="active">Create SME</li>
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
                    <form id="create-judge-form" action="{{route('admin.sme.store')}}" method="post" class="form-horizontal">
                        @csrf
                        <div class="card-header">
                            <h3 class="text-center">Create SME</h3>
                        </div>
                        <div class="card-body">
                            <h6 class="mb-3" style="color: red;">All fields are required</h6>

                            <div class="row form-group">
                                <div class="col col-md-3"><label for="brand-name-input" class=" form-control-label">Brand Name</label></div>
                                <div class="col-12 col-md-9">
                                    <input type="text" id="sme-brand-name-input" name="brand_name"
                                           class="form-control" value="{{old('brand_name')}}" data-validation="required">
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col col-md-3"><label for="company-name-input" class=" form-control-label">Company</label></div>
                                <div class="col-12 col-md-9">
                                    <input type="text" id="company-name-input" name="company"
                                           class="form-control" value="{{old('company')}}" data-validation="required">
                                </div>
                            </div>

                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary btn-sm mb-3">
                                <i class="fa fa-dot-circle-o"></i> Create SME
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
        $('#smes-li').addClass('active')

        $.validate()

    </script>
@endsection
