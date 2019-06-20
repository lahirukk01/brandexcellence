@extends('layouts.admin')


@section('title', 'Brand Excellence Client Brands')

@section('breadcrumbs_title', 'Clients')

@section('breadcrumbs')
    <li><a href="{{route('clients.index')}}">Clients</a></li>
    <li class="active">View Client</li>
@endsection


@section('content')

    <div class="animated fadeIn">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center">Client Profile</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="">Applicant Name</label>
                            </div>
                            <div class="col-sm-8">
                                <h6>{{$client->name}}</h6>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-4">
                                <label for="">Email</label>
                            </div>
                            <div class="col-sm-8">
                                <h6>{{$client->email}}</h6>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-4">
                                <label for="">Contact Number</label>
                            </div>
                            <div class="col-sm-8">
                                <h6>{{$client->contact_number}}</h6>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-4">
                                <label for="">Designation</label>
                            </div>
                            <div class="col-sm-8">
                                <h6>{{$client->designation}}</h6>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-sm-4">
                                <label for="">Company Name</label>
                            </div>
                            <div class="col-sm-8">
                                <h6>{{$client->company->name}}</h6>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-4">
                                <label for="">Company Address</label>
                            </div>
                            <div class="col-sm-8">
                                <h6>{{$client->company->address}}</h6>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-4">
                                <label for="">VAT Registration Number</label>
                            </div>
                            <div class="col-sm-8">
                                <h6>{{$client->company->vat_registration_number}}</h6>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-4">
                                <label for="">CEO Name</label>
                            </div>
                            <div class="col-sm-8">
                                <h6>{{$client->company->ceo_name}}</h6>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-4">
                                <label for="">CEO Email</label>
                            </div>
                            <div class="col-sm-8">
                                <h6>{{$client->company->ceo_email}}</h6>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-4">
                                <label for="">CEO Contact Number</label>
                            </div>
                            <div class="col-sm-8">
                                <h6>{{$client->company->ceo_contact_number}}</h6>
                            </div>
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
        $('#clients-li').addClass('active')

    </script>
@endsection