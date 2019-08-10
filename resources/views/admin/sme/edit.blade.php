@extends('layouts.admin')


@section('title', 'Brand Excellence Super User SME Edit')

@section('breadcrumbs_title', 'SME')

@section('breadcrumbs')
    <li><a href="{{route('admin.sme.index')}}">SME</a></li>
    <li class="active">Edit SME</li>
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
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center">Edit SME</h3>
                    </div>
                    <div class="card-body">
                        <form id="edit-judge-form" action="{{route('admin.sme.update', $sme->id)}}" method="post" class="form-horizontal">
                            @csrf
                            @method('PATCH')
                            <h6 class="mb-3" style="color: red;">All fields are required</h6>

                            <div class="row form-group">
                                <div class="col col-md-3"><label for="brand-name-input" class=" form-control-label">Brand Name</label></div>
                                <div class="col-12 col-md-9">
                                    <input type="text" id="sme-brand-name-input" name="brand_name"
                                           class="form-control" value="{{ $sme->brand_name }}" data-validation="required">
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col col-md-3"><label for="company-name-input" class=" form-control-label">Company</label></div>
                                <div class="col-12 col-md-9">
                                    <input type="text" id="company-name-input" name="company"
                                           class="form-control" value="{{ $sme->company }}" data-validation="required">
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary btn-sm mb-3">
                                <i class="fa fa-dot-circle-o"></i> Update SME Details
                            </button>

                        </form>
                    </div>

                    <div class="card-footer">
                    </div>
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
