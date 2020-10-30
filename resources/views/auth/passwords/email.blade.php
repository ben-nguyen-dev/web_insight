@extends('layouts.app')

@section('style')
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-md-center">
        <div class="col-lg-6 col-md-10 block-center">
            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <div class="login-block">
                    <div class="login-title">
                        <h4>Återställ ditt lösenord</h4>
                        <p>Skriv in din registrerade emailadress så skickar vi ett email med anvisningar om hur du gör för att välja ett nytt lösenord</p>
                    </div>
                    @if (session('status'))
                        <div class="login-title-mb">
                            <img src="{{ asset('images/alert-circle.png') }}" alt="">
                            <span class="mb-top"> {{ session('status') }}</span>
                        </div>
                    @endif
                    @if(session()->has('success'))
                        <div class="col-12">
                            <div class="reset-password-message">
                                <span class="text-success"> {{ session('success') }} </span>
                            </div>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="login-title-mb">
                            <img src="{{ asset('images/alert-circle.png') }}" alt="">
                            <span class="mb-top"> {{ session('error') }}</span>
                        </div>
                    @endif
                    <div class="login-form">
                        <div class="form-group">
                            <label class="form-text">E-postadress:</label>
                            <input type="email" value="{{ old('user_name') }}" placeholder="Ange e-postadress" name="user_name" class="form-control form-log  @error('email') is-invalid @enderror" required autocomplete="email" autofocus> 
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="cart-button">
                        <button type="submit" class="btn btn-outline-primary btn-white">Skicka</button>
                        <a href="{{ route('login') }}" class="btn-forget">Tillbaka till inloggningen</a>
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
