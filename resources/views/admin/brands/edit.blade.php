@extends('layouts.client')


@section('title', 'Brand Excellence Client Profile Edit')

@section('breadcrumbs_title', 'Dashboard')

@section('breadcrumbs')
    <li><a href="{{route('clients.index')}}">Clients</a></li>
    <li class="active">Edit Profile</li>
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

            @if(session('passwordError'))
                <div class="col-md-12">
                    <div class="alert alert-danger">
                        <p>{{ session('passwordError') }}</p>
                    </div>
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
                            <div class="col-md-12">
                                <form method="POST" action="{{ route('clients.update', $client->id) }}">
                                    @csrf
                                    @method('PATCH')
                                    <div class="form-group row">
                                        <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                                        <div class="col-md-6">
                                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $client->name }}" required autocomplete="name" autofocus>

                                            @error('name')
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                                        <div class="col-md-6">
                                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $client->email }}" required autocomplete="email">

                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Designation') }}</label>

                                        <div class="col-md-6">
                                            <input id="designation" type="text" class="form-control @error('designation') is-invalid @enderror" name="designation" value="{{ $client->designation }}" required autocomplete="designation">

                                            @error('designation')
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="contact-number" class="col-md-4 col-form-label text-md-right">{{ __('Contact Number (10 digit)') }}</label>

                                        <div class="col-md-6">
                                            <input id="contact-no" type="text" class="form-control @error('contact_number') is-invalid @enderror" name="contact_number" value="{{ $client->contact_number }}" required autocomplete="contact-number">

                                            @error('contact_number')
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <hr>

                                    <div class="form-group row">
                                        <label for="company-name" class="col-md-4 col-form-label text-md-right">{{ __('Company Name') }}</label>

                                        <div class="col-md-6">
                                            <input id="company-name" type="text" class="form-control @error('company_name') is-invalid @enderror" name="company_name" value="{{ $client->company->name }}" required autocomplete="company-name">

                                            @error('company_name')
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="company-address" class="col-md-4 col-form-label text-md-right">{{ __('Company Address') }}</label>

                                        <div class="col-md-6">
                                            <input id="company-address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ $client->company->address }}" required autocomplete="address">

                                            @error('address')
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="ceo-name" class="col-md-4 col-form-label text-md-right">{{ __('CEO Name') }}</label>

                                        <div class="col-md-6">
                                            <input id="ceo-name" type="text" class="form-control @error('ceo_name') is-invalid @enderror" name="ceo_name" value="{{ $client->company->ceo_name }}" required autocomplete="ceo-name">

                                            @error('ceo_name')
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="ceo-email" class="col-md-4 col-form-label text-md-right">{{ __('CEO Email') }}</label>

                                        <div class="col-md-6">
                                            <input id="ceo-email" type="text" class="form-control @error('ceo_email') is-invalid @enderror" name="ceo_email" value="{{ $client->company->ceo_email }}" required autocomplete="ceo-email">

                                            @error('ceo_email')
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="ceo-contact-number" class="col-md-4 col-form-label text-md-right">{{ __('CEO Contact Number (10 digit)') }}</label>

                                        <div class="col-md-6">
                                            <input id="ceo-name" type="text" class="form-control @error('ceo_contact_number') is-invalid @enderror" name="ceo_contact_number" value="{{ $client->company->ceo_contact_number }}" required autocomplete="ceo-contact-number">

                                            @error('ceo_contact_number')
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row mb-0">
                                        <div class="col-md-6 offset-md-4">
                                            <button type="submit" class="btn btn-primary">
                                                {{ __('Update Profile') }}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-12">

                                <form action="{{route('clients.update.password', $client->id)}}" method="post">
                                    @csrf
                                    @method('PATCH')

                                    <div class="form-group row">
                                        <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('New Password (Alpha Numeric)') }}</label>

                                        <div class="col-md-6">
                                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password">

                                            @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                                        <div class="col-md-6">
                                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" autocomplete="new-password">
                                        </div>
                                    </div>

                                    <div class="form-group row mb-0">
                                        <div class="col-md-6 offset-md-4">
                                            <button type="submit" class="btn btn-primary">
                                                {{ __('Update Password') }}
                                            </button>
                                        </div>
                                    </div>

                                </form>

                            </div>
                        </div>
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
