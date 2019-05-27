@extends('layouts.client')

@section('title', 'Brand Excellence Client Create Brand')

@section('breadcrumbs_title', 'Brands')

@section('breadcrumbs')
    <li><a href="{{route('brands.index')}}">Brands</a></li>
    <li class="active">Create Brand</li>
@endsection

@section('content')
    <div class="animated fadeIn">
        <div class="row">

            <div class="col-md-12">
                <div class="card">
                    <form id="create-brand-form" action="{{route('brands.store')}}" method="post" enctype="multipart/form-data" class="form-horizontal">
                        @csrf
                        <div class="card-header">
                            <h3 class="text-center">Create Brand</h3>
                        </div>
                        <div class="card-body">
                            <h6 class="mb-3" style="color: red;">All fields are required</h6>
                            <div class="row form-group">
                                <div class="col col-md-3"><label for="name-input" class=" form-control-label">Name</label></div>
                                <div class="col-12 col-md-9">
                                    <input type="text" id="brand-name-input" name="name"
                                           class="form-control" value="{{old('name')}}" data-validation="required">
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col col-md-3"><label for="category-select" class=" form-control-label">Category</label></div>
                                <div class="col-12 col-md-9">
                                    <select name="category" id="" data-validation="required">
                                        <option value="">Select Category</option>
                                        @foreach($categories as $c)
                                            <option value="{{$c->id}}" @if(old('category') == $c->id) {{'selected'}} @endif>{{$c->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col col-md-3"><label for="brand-description" class=" form-control-label">Description (max length 60 characters)</label></div>
                                <div class="col-12 col-md-9"><textarea name="brand_description" id="" rows="6" class="form-control" maxlength="60" data-validation="required"></textarea></div>
                            </div>

                            <div class="row form-group">
                                <div class="col col-md-3"><label for="entry-kit-input" class=" form-control-label">Entry Kit (pdf file)</label></div>
                                <div class="col-12 col-md-9">
                                    <input type="file" id="" name="entry_kit"
                                     class="form-control-file" required accept="application/pdf" value="{{old('entry_kit')}}"
                                           data-validation="mime"
                                           data-validation-allowing="pdf" >
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col col-md-3"><label for="logo-input" class=" form-control-label">Logo (ai file)</label></div>
                                <div class="col-12 col-md-9">
                                    <input type="file" id="" name="logo" class="form-control-file" required value="{{old('logo')}}"
                                           accept="application/postscript" data-validation="ai_file">
                                </div>
                            </div>

                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary btn-sm mb-3">
                                <i class="fa fa-dot-circle-o"></i> Submit
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
        $('#brands-li').addClass('active')

        $.formUtils.addValidator({
            name : 'ai_file',
            validatorFunction : function(value, $el, config, language, $form) {
                // return parseInt(value, 10) % 2 === 0;

                const pattern = /.+\.ai$/
                const fileOb = $el.get()[0].files[0]
                if( fileOb != undefined) {
                    if(fileOb.type == 'application/postscript' && fileOb.name.match(pattern)) {
                        return true
                    }
                }

                return false

            },
            errorMessage : 'Only ai files are allowed',
        });

        // $.validate({
        //     modules: 'file'
        // })

        $.formUtils.loadModules('file');

        $('#create-brand-form').submit(function (e) {
            e.preventDefault()

            if($('#create-brand-form').isValid()) {
                alert('Inputs are valid')
            } else {
                alert('Inputs are invalid')
            }
        })



    </script>
@endsection