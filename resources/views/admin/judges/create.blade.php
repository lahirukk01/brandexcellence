@extends('layouts.admin')

@section('title', 'Brand Excellence Admin Create Judge')

@section('breadcrumbs_title', 'Judges')

@section('breadcrumbs')
    <li><a href="{{route('admin.judge.index')}}">Judges</a></li>
    <li class="active">Create Judge</li>
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
                    <form id="create-judge-form" action="{{route('admin.judge.store')}}" method="post" class="form-horizontal">
                        @csrf
                        <div class="card-header">
                            <h3 class="text-center">Create Judge</h3>
                        </div>
                        <div class="card-body">
                            <h6 class="mb-3" style="color: red;">All fields are required</h6>

                            <div class="row form-group">
                                <div class="col col-md-3"><label for="name-input" class=" form-control-label">Name</label></div>
                                <div class="col-12 col-md-9">
                                    <input type="text" id="judge-name-input" name="name"
                                           class="form-control" value="{{old('name')}}" data-validation="required">
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col col-md-3"><label for="email-input" class=" form-control-label">Email</label></div>
                                <div class="col-12 col-md-9">
                                    <input type="text" id="judge-email-input" name="email"
                                           class="form-control" value="{{old('email')}}" data-validation="required email">
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col col-md-3"><label for="" class="form-control-label">Select Industry Categories of Judge</label></div>
                                <div class="col-12 col-md-9">
                                    <div class="form-control" style="height: 300px; overflow-y: scroll;">
                                        <div class="checkbox">
                                            <label>
                                                <input id="select-all-categories" class="mr-2" type="checkbox" name="">
                                                <span class="bg-info" style="color: white;">Select All</span>
                                            </label>
                                        </div>
                                    @foreach($industryCategories as $ic)
                                        <div class="checkbox">
                                            <label>
                                                <input class="mr-2" type="checkbox" name="industry_categories[]"
                                                       value="{{ $ic->id }}">{{ $ic->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col col-md-3"><label for="password-input" class=" form-control-label">Password</label></div>
                                <div class="col-12 col-md-9">
                                    <input type="password" id="judge-password-input" name="password"
                                           class="form-control" value="" data-validation="required">
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col col-md-3"><label for="password-confirmation-input" class=" form-control-label">Confirm Password</label></div>
                                <div class="col-12 col-md-9">
                                    <input type="password" id="judge-password-confirmation-input" name="password_confirmation"
                                           class="form-control" value="" data-validation="required">
                                </div>
                            </div>

                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary btn-sm mb-3">
                                <i class="fa fa-dot-circle-o"></i> Create Judge
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
        $('#judges-li').addClass('active')

        $.validate()

        $('#select-all-categories').click(function () {
            if($(this).is(':checked')) {
                $('input[name="industry_categories[]"]').prop('checked', true)
            }
        })

    </script>
@endsection
