@extends('layouts.app')
@section('style')
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-md-center">
        <div class="col-lg-6 col-md-10 block-center">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="login-block">
                    <div class="login-title d-none d-sm-block">
                        <h4>Logga in</h4>
                        <p>Välkommen till Public Insight! Logga in med dina användaruppgifter.</p>
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
                    <div class="login-form">
                        <div class="form-group">
                            <label class="form-text">E-postadress:</label>
                            <input type="email" value="{{ old('user_name') }}" placeholder="Ange e-postadress" name="user_name" class="form-control form-log  @error('email') is-invalid @enderror" required> 
                            @error('user_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-text">Lösenord:</label>
                            <input type="password" value="" name="password" placeholder="Ange lösenord" class="form-control form-log" required> 
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="cart-button">
                        <button type="submit" class="btn btn-outline-primary btn-white">Logga in</button>
                        <a href="{{ route('password.request') }}" class="btn-forget">Glömt lösenordet?</a>
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
