@extends('layouts.app')

@section('content')
<head>
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
</head>
<body>
    <div id="login">
        <h3 class="text-center text-white pt-5">{{ __('Login form') }}</h3>
        <div class="container">
            <div id="login-row" class="row justify-content-center align-items-center">
                <div id="login-column" class="col-md-6">
                    <div id="login-box" class="col-md-12">
                        <form id="login-form" class="form" action="{{ route('login') }}" method="POST">
                            @csrf
                            <h3 class="text-center text-info">{{ __('Login') }}</h3>
                            <div class="form-group">
                                <label for="username" class="text-info">{{ __('Username (Nomor Induk Staff)') }}:</label><br>
                                <input type="text" name="username" id="username" class="form-control @error('username') is-invalid @enderror" value="{{ old('username') }}" required autocomplete="username" autofocus>
                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="password" class="text-info">{{ __('Password') }}:</label><br>
                                <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" required autocomplete="current-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="remember-me" class="text-info"><span>{{ __('Remember me') }}</span> <span><input id="remember-me" name="remember" type="checkbox" {{ old('remember') ? 'checked' : '' }}></span></label><br>
                                <input type="submit" name="submit" class="btn btn-info btn-md" value="{{ __('submit') }}">
                            </div>
                             <div class="text-center">
                 <a href="/password/reset" class="inline-block text-sm text-blue-500 hover:text-blue-800">Lupa Password?</a>
            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
@endsection