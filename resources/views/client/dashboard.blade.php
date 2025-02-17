@extends('layouts.client')


@section('title', 'Brand Excellence Client Dashboard')

@section('breadcrumbs_title', 'Dashboard')

@section('breadcrumbs')
    <li class="active">Dashboard</li>
@endsection


@section('content')

    <div class="animated fadeIn">
        <div class="row">

            @if (session('status'))
                <div class="alert alert-success alert-dismissible fade show floating-response" role="alert">
                    {{ session('status') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="col-md-12">
                <div id="result-message"></div>
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center">Client Details</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h4 class="text-center mb-3">User</h4>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <p>Name</p>
                                    </div>
                                    <div class="col-sm-8">
                                        <p>{{$client->name}}</p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-4">
                                        <p>Email</p>
                                    </div>
                                    <div class="col-sm-8">
                                        <p>{{$client->email}}</p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-4">
                                        <p>Designation</p>
                                    </div>
                                    <div class="col-sm-8">
                                        <p>{{$client->designation}}</p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-4">
                                        <p>Contact Number</p>
                                    </div>
                                    <div class="col-sm-8">
                                        <p>{{$client->contact_number}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h4 class="text-center mb-3">Company</h4>

                                <div class="row">
                                    <div class="col-sm-4">
                                        <p>Name</p>
                                    </div>
                                    <div class="col-sm-8">
                                        <p>{{$client->company->name}}</p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-4">
                                        <p>Address</p>
                                    </div>
                                    <div class="col-sm-8">
                                        <p>{{$client->company->address}}</p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-4">
                                        <p>VAT Registration Number</p>
                                    </div>
                                    <div class="col-sm-8">
                                        <p>{{$client->company->vat_registration_number}}</p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-4">
                                        <p>CEO Name</p>
                                    </div>
                                    <div class="col-sm-8">
                                        <p>{{$client->company->ceo_name}}</p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-4">
                                        <p>CEO Email</p>
                                    </div>
                                    <div class="col-sm-8">
                                        <p>{{$client->company->ceo_email}}</p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-4">
                                        <p>CEO Contact Number</p>
                                    </div>
                                    <div class="col-sm-8">
                                        <p>{{$client->company->ceo_contact_number}}</p>
                                    </div>
                                </div>

                            </div>

                            <hr>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{route('client.edit', $client->id)}}" class="btn btn-primary">Edit Profile</a>
                    </div>
                </div>
            </div>


        </div>
    </div><!-- .animated -->

@endsection

@section('scripts')
    <script>
        $('#dashboard-li').addClass('active')
    </script>
@endsection
