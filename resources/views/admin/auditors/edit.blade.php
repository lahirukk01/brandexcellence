@extends('layouts.admin')


@section('title', 'Brand Excellence Super User Judge Edit')

@section('breadcrumbs_title', 'Auditors')

@section('breadcrumbs')
    <li><a href="{{route('admin.auditor.index')}}">Auditors</a></li>
    <li class="active">Edit Auditor</li>
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
                        <h3 class="text-center">Edit Auditor</h3>
                    </div>
                    <div class="card-body">
                        <form id="edit-judge-form" action="{{route('admin.auditor.update', $auditor->id)}}" method="post" class="form-horizontal">
                            @csrf
                            @method('PATCH')

                            <div class="row form-group">
                                <div class="col col-md-3"><label for="name-input" class=" form-control-label">Name</label></div>
                                <div class="col-12 col-md-9">
                                    <input type="text" id="judge-name-input" name="name"
                                           class="form-control" value="{{ $auditor->name }}" data-validation="required">
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col col-md-3"><label for="email-input" class=" form-control-label">Email</label></div>
                                <div class="col-12 col-md-9">
                                    <input type="text" id="judge-email-input" name="email"
                                           class="form-control" value="{{ $auditor->email }}" data-validation="required email">
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col col-md-3"><label for="telephone-input" class=" form-control-label">Telephone (10 digit)</label></div>
                                <div class="col-12 col-md-9">
                                    <input type="text" id="auditor-telephone-input" name="contact_number"
                                           class="form-control" value="{{ $auditor->contact_number }}" data-validation="required">
                                </div>
                            </div>

{{--                            <div class="row form-group">--}}
{{--                                <div class="col col-md-3"><label for="" class="form-control-label">Select Industry Categories of Judge</label></div>--}}
{{--                                <div class="col-12 col-md-9">--}}
{{--                                    <div class="form-control" style="height: 300px; overflow-y: scroll;">--}}
{{--                                        @foreach($industryCategories as $ic)--}}
{{--                                            <div class="checkbox">--}}
{{--                                                <label>--}}
{{--                                                    <input class="mr-2" type="checkbox" name="industry_categories[]"--}}
{{--                                                           value="{{ $ic->id }}"--}}
{{--                                                    @if(in_array($ic->id, $selectedIndustryCategories)) checked @endif>--}}
{{--                                                    {{ $ic->name }}--}}
{{--                                                </label>--}}
{{--                                            </div>--}}
{{--                                        @endforeach--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}

                            <button type="submit" class="btn btn-primary btn-sm mb-3">
                                <i class="fa fa-dot-circle-o"></i> Update Auditor Details
                            </button>

                        </form>
                    </div>

                    <div class="card-footer">
                        <form id="update-judge-password-form" action="{{route('admin.auditor.update_password', $auditor->id)}}" method="post" class="form-horizontal">
                            @csrf
                            @method('PATCH')
                            <div class="row form-group">
                                <div class="col col-md-3"><label for="password-input" class=" form-control-label">Password</label></div>
                                <div class="col-12 col-md-9">
                                    <input type="password" id="auditor-password-input" name="password"
                                           class="form-control" value="" data-validation="required">
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col col-md-3"><label for="password-confirmation-input" class=" form-control-label">Confirm Password</label></div>
                                <div class="col-12 col-md-9">
                                    <input type="password" id="auditor-password-confirmation-input" name="password_confirmation"
                                           class="form-control" value="" data-validation="required">
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary btn-sm mb-3">
                                <i class="fa fa-dot-circle-o"></i> Update Auditor Password
                            </button>
                        </form>
                    </div>
                </div>
            </div>


        </div>
    </div><!-- .animated -->

@endsection

@section('scripts')
    <script src="{{asset('vendors/form/src/jquery.form.js')}}"></script>
    <script>
        $('#auditors-li').addClass('active')

        $.validate()
    </script>
@endsection
