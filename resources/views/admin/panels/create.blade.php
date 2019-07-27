@extends('layouts.admin')

@section('title', 'Brand Excellence Admin Create Panel')

@section('breadcrumbs_title', 'Panels')

@section('breadcrumbs')
    <li><a href="{{route('admin.panel.index')}}">Panels</a></li>
    <li class="active">Create Panel</li>
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
                    <form id="create-judge-form" action="{{route('admin.panel.store')}}" method="post" class="form-horizontal">
                        @csrf
                        <div class="card-header">
                            <h3 class="text-center">Create Panel</h3>
                        </div>
                        <div class="card-body">
                            <h6 class="mb-3" style="color: red;">All fields are required</h6>

                            <div class="row form-group">
                                <div class="col col-md-3"><label for="name-input" class=" form-control-label">Name</label></div>
                                <div class="col-12 col-md-9">
                                    <input type="text" id="panel-name-input" name="name"
                                           class="form-control" value="{{old('name')}}" data-validation="required">
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col col-md-3"><label for="" class="form-control-label">Select auditor for the panel</label></div>
                                <div class="col-12 col-md-9">
                                    <select name="auditor" id="" data-validation="required">
                                        <option value=""></option>
                                        @foreach($auditors as $a)
                                        <option value="{{ $a->id }}">{{ $a->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col col-md-3"><label for="" class="form-control-label">Select categories for the panel</label></div>
                                <div class="col-12 col-md-9">
                                    <div class="form-control" style="height: 400px; overflow-y: scroll;">
                                    @foreach($categories as $c)
                                        <div class="checkbox">
                                            <label>
                                                <input class="mr-2" type="checkbox" name="categories[]"
                                                       value="{{ $c->id }}">{{ $c->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col col-md-3"><label for="" class="form-control-label">Select judges for the panel</label></div>
                                <div class="col-12 col-md-9">
                                    <div class="form-control" style="height: 300px; overflow-y: scroll;">
                                    @foreach($judges as $j)
                                        <div class="checkbox">
                                            <label>
                                                <input class="mr-2" type="checkbox" name="judges[]"
                                                       value="{{ $j->id }}">{{ $j->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary btn-sm mb-3">
                                <i class="fa fa-dot-circle-o"></i> Create Panel
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
        $('#panels-li').addClass('active')

        $.validate()

    </script>
@endsection
