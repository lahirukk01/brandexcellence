@extends('layouts.admin')

@section('title', 'Brand Excellence Admin Create Panel')

@section('breadcrumbs_title', 'Panels')

@section('breadcrumbs')
    <li><a href="{{route('admin.panel.index')}}">Panels</a></li>
    <li class="active">Edit Panel</li>
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
                    <form id="create-judge-form" action="{{route('admin.panel.update', $panel->id)}}" method="post" class="form-horizontal">
                        @csrf
                        @method('PATCH')
                        <div class="card-header">
                            <h3 class="text-center">Edit Panel</h3>
                        </div>
                        <div class="card-body">
                            <h6 class="mb-3" style="color: red;">All fields are required</h6>

                            <div class="row form-group">
                                <div class="col col-md-3"><label for="name-input" class=" form-control-label">Name</label></div>
                                <div class="col-12 col-md-9">
                                    <input type="text" id="panel-name-input" name="name"
                                           class="form-control" value="{{ $panel->name }}" data-validation="required">
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col col-md-3"><label for="" class="form-control-label">Select auditor for the panel</label></div>
                                <div class="col-12 col-md-9">
                                    <select name="auditor" id="" data-validation="required">
                                        <option value=""></option>
                                        @foreach($auditors as $a)
                                            <option value="{{ $a->id }}" @if($panelAuditorId === $a->id) selected @endif>{{ $a->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col col-md-3"><label for="" class="form-control-label">Select categories for the panel</label></div>
                                <div class="col-12 col-md-9">
                                    <div class="form-control" style="height: 430px; overflow-y: scroll;">
                                        @foreach($categories as $c)
                                            @if($c->code == 'SME')
                                            <div class="checkbox bg-flat-color-1">
                                                <label>
                                                    <input class="mr-2 sme" type="checkbox" name="categories[]"
                                                           value="{{ $c->id }}" @if( $panelCategories->contains($c->id)) checked @endif>{{ $c->name }}
                                                </label>
                                            </div>
                                            @else
                                            <div class="checkbox">
                                                <label>
                                                    <input class="mr-2 other-categories" type="checkbox" name="categories[]"
                                                           value="{{ $c->id }}" @if( $panelCategories->contains($c->id)) checked @endif>{{ $c->name }}
                                                </label>
                                            </div>
                                            @endif
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
                                                           value="{{ $j->id }}" @if( $panelJudges->contains($j->id) ) checked @endif>{{ $j->name }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary btn-sm mb-3">
                                <i class="fa fa-dot-circle-o"></i> Update Panel
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

        $('.sme').change(function () {
            if($(this).prop('checked') == true) {
                $('.other-categories').prop('checked', false)
            }
        })

        $('.other-categories').change(function () {
            if($(this).prop('checked') == true) {
                $('.sme').prop('checked', false)
            }
        })

    </script>
@endsection
