@extends('layouts.app')
@section('style')
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-md-center">
        <div class="col-lg-6 col-md-10 block-center">
            <form method="POST" action="{{ route('user.invite') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <div class="login-block">
                    <div class="login-title d-none d-sm-block">
                        <h4>Invite User</h4>
                    </div>
                    @if (session()->has('message'))
                        <div class="login-title-mb">
                            <span class="mb-top">{{ session()->get('message') }}</span>
                        </div>
                    @endif
                    @if (session()->has('warning'))
                        <div class="login-title-mb">
                            <img src="{{ asset('images/alert-circle.png') }}" alt="">
                            <span class="mb-top">{{ session('warning') }}</span>
                        </div>
                    @endif
                    @error('token')
                        <div class="login-title-mb">
                            <img src="{{ asset('images/alert-circle.png') }}" alt="">
                            <span class="mb-top">{{ $message }}</span>
                        </div>
                    @enderror
                    <div class="login-form">
                        <div class="form-group">
                            <label class="form-text">Name:</label>
                            <input type="text" value="{{ old('full_name') }}" placeholder="Name" name="full_name" class="form-control form-log" required> 
                            @error('full_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password" class="form-text">{{ __('Password') }}</label>
                            <input id="password" type="password" class="form-control form-log @error('password') is-invalid @enderror" placeholder="Ange Password" name="password" required autocomplete="new-password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password-confirm" class="form-text">{{ __('Confirm Password') }}</label>
                            <input id="password-confirm" type="password" class="form-control form-log" name="password_confirmation" placeholder="Ange Confirm Password" required autocomplete="new-password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="cart-button">
                        <button type="submit" class="btn btn-outline-primary btn-white">Accept</button>
                    </div>
                </div>
            </form>
            <div class="bottom-login">
                <div class="bottom-header">
                    <h5>Jag är ny här</h5>
                    <a href="{{ route('register') }}" type="button" class="btn btn-primary btn-regisrera-dig">Registrera dig</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
