@extends('layouts.admin')

@section('title', 'Brand Excellence Super User Create Administrator')

@section('breadcrumbs_title', 'Administrators')

@section('breadcrumbs')
    <li><a href="{{route('super.admin.index')}}">Administrators</a></li>
    <li class="active">Create Administrator</li>
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
                    <form id="create-brand-form" action="{{route('super.admin.store')}}" method="post" class="form-horizontal">
                        @csrf
                        <div class="card-header">
                            <h3 class="text-center">Create Administrator</h3>
                        </div>
                        <div class="card-body">
                            <h6 class="mb-3" style="color: red;">All fields are required</h6>

                            <div class="row form-group">
                                <div class="col col-md-3"><label for="name-input" class=" form-control-label">Name</label></div>
                                <div class="col-12 col-md-9">
                                    <input type="text" id="admin-name-input" name="name"
                                           class="form-control" value="{{old('name')}}" data-validation="required">
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col col-md-3"><label for="email-input" class=" form-control-label">Email</label></div>
                                <div class="col-12 col-md-9">
                                    <input type="text" id="admin-email-input" name="email"
                                           class="form-control" value="{{old('email')}}" data-validation="required">
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col col-md-3"><label for="contact-input" class=" form-control-label">Contact Number (10 Digits)</label></div>
                                <div class="col-12 col-md-9">
                                    <input type="text" id="contact-number-input" name="contact_number"
                                           class="form-control" value="{{old('contact_number')}}" data-validation="required">
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col col-md-3"><label for="designation-input" class=" form-control-label">Designation</label></div>
                                <div class="col-12 col-md-9">
                                    <input type="text" id="designation-input" name="designation"
                                           class="form-control" value="{{old('designation')}}" data-validation="required">
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col col-md-3"><label for="password-input" class=" form-control-label">Password (Alpha Numeric)</label></div>
                                <div class="col-12 col-md-9">
                                    <input type="password" id="password-input" name="password"
                                           class="form-control" value="" data-validation="required" autocomplete="off">
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col col-md-3"><label for="password-confirmation-input" class=" form-control-label">Confirm Password</label></div>
                                <div class="col-12 col-md-9">
                                    <input type="password" id="password-confirmation-input" name="password_confirmation"
                                           class="form-control" value="" data-validation="required" autocomplete="off">
                                </div>
                            </div>

                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary btn-sm mb-3">
                                <i class="fa fa-dot-circle-o"></i> Create Admin
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
        $('#admins-li').addClass('active')

        $.validate()

    </script>
@endsection