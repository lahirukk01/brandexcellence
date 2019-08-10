@extends('layouts.auditor')

@section('title', 'Brand Excellence Auditor Reset Password')

@section('breadcrumbs_title', 'Reset Password')

@section('breadcrumbs')
    <li class="active">Reset Password</li>
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
            @if (session('status'))
            <div class="alert alert-success alert-dismissible fade show floating-response" role="alert">
                {{ session('status') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif

            @if (session('passwordError'))
                <div class="alert alert-danger alert-dismissible fade show floating-response" role="alert">
                    {{ session('passwordError') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="col-md-12">
                <div class="card">
                    <form id="create-brand-form" action="{{route('auditor.self_update_password')}}" method="post" enctype="multipart/form-data" class="form-horizontal">
                        @csrf
                        @method('PATCH')
                        <div class="card-header">
                            <h3 class="text-center">Reset Password</h3>
                        </div>
                        <div class="card-body">
                            <h6 class="mb-3" style="color: red;">All fields are required</h6>

                            <div class="row form-group">
                                <div class="col col-md-3"><label for="current-password-input" class=" form-control-label">Current Password</label></div>
                                <div class="col-12 col-md-9">
                                    <input type="password" id="current-password-input" name="current_password"
                                           class="form-control" value="" data-validation="required" data-validation-length="3-15">
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col col-md-3"><label for="new-password-input" class=" form-control-label">New Password (alpha numeric)</label></div>
                                <div class="col-12 col-md-9">
                                    <input type="password" id="new-password-input" name="password"
                                           class="form-control" value="" data-validation="required" data-validation-length="3-15">
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col col-md-3"><label for="new-password-confirm-input" class=" form-control-label">Confirm Password</label></div>
                                <div class="col-12 col-md-9">
                                    <input type="password" id="new-password-confirm-input" name="password_confirmation"
                                           class="form-control" value="" data-validation="required" data-validation-length="3-15">
                                </div>
                            </div>

                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary btn-sm mb-3">
                                <i class="fa fa-dot-circle-o"></i> Update Password
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
        $('#resetpw-li').addClass('active')

        $.validate()

    </script>
@endsection
