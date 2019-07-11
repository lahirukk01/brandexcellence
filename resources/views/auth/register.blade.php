@extends('layouts.app')


@section('title', 'Brand Excellence Registration')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

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
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

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
                                <input id="designation" type="text" class="form-control @error('designation') is-invalid @enderror" name="designation" value="{{ old('designation') }}" required autocomplete="designation">

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
                                <input id="contact-no" type="text" class="form-control @error('contact_number') is-invalid @enderror" name="contact_number" value="{{ old('contact_number') }}" required autocomplete="contact-number">

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
                                <input id="company-name" type="text" class="form-control @error('company_name') is-invalid @enderror" name="company_name" value="{{ old('company_name') }}" required autocomplete="company-name">

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
                                <input id="company-address" type="text" class="form-control @error('company_address') is-invalid @enderror" name="company_address" value="{{ old('company_address') }}" required autocomplete="company-address">

                                @error('company_address')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="vat-registration-number" class="col-md-4 col-form-label text-md-right">{{ __('VAT Registration Number') }}</label>

                            <div class="col-md-6">
                                <input id="vat-registration-number" type="text" class="form-control @error('vat_registration_number') is-invalid @enderror" name="vat_registration_number" value="{{ old('vat_registration_number') }}" required autocomplete="vat-registration-number">

                                @error('vat_registration_number')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="svat-nbt" class="col-md-4 col-form-label text-md-right">{{ __('Leave what is appropriate') }}</label>

                            <div class="col-md-6" style="padding-top: 7px; padding-bottom: 7px;">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="svat">SVAT <input type="checkbox" name="svat-checkbox" id="" checked></label>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="svat">NBT <input type="checkbox" name="nbt-checkbox" id="" checked></label>
                                    </div>

{{--                                @error('vat_registration_number')--}}
{{--                                <span class="invalid-feedback" role="alert">--}}
{{--                                        <strong>{{ $message }}</strong>--}}
{{--                                    </span>--}}
{{--                                @enderror--}}
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="ceo-name" class="col-md-4 col-form-label text-md-right">{{ __('CEO Name') }}</label>

                            <div class="col-md-6">
                                <input id="ceo-name" type="text" class="form-control @error('ceo_name') is-invalid @enderror" name="ceo_name" value="{{ old('ceo_name') }}" required autocomplete="ceo-name">

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
                                <input id="ceo-email" type="text" class="form-control @error('ceo_email') is-invalid @enderror" name="ceo_email" value="{{ old('ceo_email') }}" required autocomplete="ceo-email">

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
                                <input id="ceo-name" type="text" class="form-control @error('ceo_contact_number') is-invalid @enderror" name="ceo_contact_number" value="{{ old('ceo_contact_number') }}" required autocomplete="ceo-contact-number">

                                @error('ceo_contact_number')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <hr>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password (Alpha Numeric)') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

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
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
