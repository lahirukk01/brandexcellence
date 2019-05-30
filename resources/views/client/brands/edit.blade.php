@extends('layouts.client')

@section('title', 'Brand Excellence Client Edit Brand')

@section('breadcrumbs_title', 'Brands')

@section('breadcrumbs')
    <li><a href="{{route('brands.index')}}">Brands</a></li>
    <li class="active">Edit Brand</li>
@endsection

@section('content')
    <div class="animated fadeIn">

        <div class="row">
            <div class="col-md-12">
                <div style="display: none" class="alert alert-danger"></div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <form id="edit-brand-form" action="{{route('brands.update', $brand->id)}}" method="post" enctype="multipart/form-data" class="form-horizontal">
                        @csrf
                        @method('PATCH')
                        <div class="card-header">
                            <h3 class="text-center">Edit Brand</h3>
                        </div>
                        <div class="card-body">
                            <h6 class="mb-3" style="color: red;">All fields are required</h6>
                            <div class="row form-group">
                                <div class="col col-md-3"><label for="name-input" class=" form-control-label">Name</label></div>
                                <div class="col-12 col-md-9">
                                    <input type="text" id="brand-name-input" name="name"
                                           class="form-control" value="{{ $brand->name }}" data-validation="required">
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col col-md-3"><label for="category-select" class=" form-control-label">Category</label></div>
                                <div class="col-12 col-md-9">
                                    <select name="category_id" id="" data-validation="required">
                                        <option value="">Select Category</option>
                                        @foreach($categories as $c)
                                            <option value="{{$c->id}}" @if( $brand->category_id == $c->id) {{'selected'}} @endif>{{$c->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col col-md-3"><label for="brand-description" class=" form-control-label">Description (max length 60 characters)</label></div>
                                <div class="col-12 col-md-9"><textarea name="description" id="" rows="6" class="form-control" maxlength="60" data-validation="required">{{ $brand->description }}</textarea></div>
                            </div>

                            <div class="row form-group">
                                <div class="col col-md-3"><label for="entry-kit-input" class=" form-control-label">Entry Kit (pdf file)</label></div>
                                <div class="col-12 col-md-9">
                                    <input type="file" id="" name="entry_kit"
                                           class="form-control-file" accept="application/pdf" value=""
                                           data-validation="mime"
                                           data-validation-allowing="pdf" >
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col col-md-3"><label for="logo-input" class=" form-control-label">Brand Logo (ai file)</label></div>
                                <div class="col-12 col-md-9">
                                    <input type="file" id="" name="logo" class="form-control-file" value=""
                                           accept="application/postscript" data-validation="ai_file">
                                </div>
                            </div>

                            <div class="progress">
                                <div class="progress-bar" role="progressbar" aria-valuenow="" aria-valuemin="0" aria-valuemax="100"></div>
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

                const pattern = /.+\.ai$/
                const fileOb = $el.get()[0].files[0]
                if( fileOb !== undefined) {
                    if(fileOb.type === 'application/postscript' && fileOb.name.match(pattern)) {
                        return true
                    } else {
                        return false
                    }
                }

                return true
            },

            errorMessage : 'Only ai files are allowed',
        })

        $.formUtils.loadModules('file')

        let bar = $('.progress-bar')

        $('form').ajaxForm({
            beforeSubmit: function () {
                if($('#edit-brand-form').isValid()) {
                    return true
                } else {
                    return false
                }
            },

            beforeSend: function () {
                const value = 0
                const percentValue = value + '%'
                bar.attr('aria-valuenow', value)
                bar.width(percentValue)
                bar.html(percentValue)
            },

            uploadProgress: function(event, position, total, percentComplete) {
                const percentValue = percentComplete + '%';
                bar.width(percentValue)
                bar.attr('aria-valuenow', percentComplete)
                bar.html(percentValue);
            },

            complete: function(xhr, textStatus) {
                $('.alert-danger').empty()
                $('.alert-danger').hide()
                const response = JSON.parse(xhr.responseText)
                console.log(response)
                if(response.success !== undefined) {
                    $('#edit-brand-form')[0].reset()
                    const percentVal = 'Form submitted successfully';
                    bar.width('100%')
                    bar.attr('aria-valuenow', '100')
                    bar.html(percentVal);
                    alert('Form updated successfully')
                    window.location.assign('{{route('brands.index')}}')
                } else {
                    $.each(response.errors, function (key, val) {
                        $('.alert-danger').append(`<p>${val}</p>`)
                    })
                    $('.alert-danger').show()

                    bar.html('Failed to submit form');
                    alert('Failed to submit form')
                }

                // console.log(xhr)
                // console.log(textStatus)
            },

            error: function (xhr, textStatus) {
                bar.html('Failed to submit form');
            }

        })




    </script>
@endsection