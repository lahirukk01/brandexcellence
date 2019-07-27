@extends('layouts.client')


@section('title', 'Brand Excellence Client Brands')

@section('breadcrumbs_title', 'Brands')

@section('breadcrumbs')
    <li><a href="{{route('client.brand.index')}}">Brands</a></li>
    <li class="active">View Brand</li>
@endsection


@section('content')

    <div class="animated fadeIn">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center">{{$brand->name}}</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="">ID</label>
                            </div>
                            <div class="col-sm-8">
                                <h6>{{$brand->id_string}}</h6>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-4">
                                <label for="">Category</label>
                            </div>
                            <div class="col-sm-8">
                                <h6>{{$brand->category->name}}</h6>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-4">
                                <label for="">Industry Category</label>
                            </div>
                            <div class="col-sm-8">
                                <h6>{{$brand->industryCategory->name}}</h6>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <p class="text-justify">{{$brand->description}}</p>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-sm-4">
                                <a class="btn btn-primary" target="_blank" href="{{route('client.brand.show_entry_kit', $brand->id)}}">Entry Kit</a>
                            </div>
                            <div class="col-sm-4">
                                <a href="{{ asset($brand->logo) }}" class="btn btn-info" download>Logo</a>
                            </div>
                            @if($brand->supporting_material)
                            <div class="col-sm-4">
                                <a target="_blank"  href="{{ asset($brand->supporting_material) }}" class="btn btn-success">Supporting Material</a>
                            </div>
                            @endif
                        </div>

                    </div>
                    <div class="card-footer">

                    </div>
                </div>
            </div>


        </div>
    </div><!-- .animated -->

@endsection

@section('scripts')
    <script>
        $('#brands-li').addClass('active')

    </script>
@endsection