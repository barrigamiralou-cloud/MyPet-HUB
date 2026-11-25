@extends('layouts.auth')

@section('title', 'Log in')

@section('content')
    <h1>Welcome back</h1>
    <p class="lead">Log in with your username or email.</p>

    @if (session('status'))
        <div class="notice">{{ session('status') }}</div>
    @endif

    @if ($lockSeconds > 0)
        <div class="notice notice-error" id="lock-notice" data-seconds="{{ $lockSeconds }}">
            Too many attempts. Try again in <strong id="lock-timer">{{ $lockSeconds }}</strong>s.
        </div>
    @endif

    <form method="POST" action="{{ route('login.store') }}" class="form" data-once>
        @csrf

        <label class="field">
            <span>Username or email</span>
            <input type="text" name="login" value="{{ old('login') }}" required autofocus autocomplete="username">
            @error('login') <small class="error">{{ $message }}</small> @enderror
        </label>

        <label class="field">
            <span>Password</span>
            <input type="password" name="password" required autocomplete="current-password">
            @error('password') <small class="error">{{ $message }}</small> @enderror
        </label>

        <label class="check">
            <input type="checkbox" name="remember" value="1"> <span>Keep me logged in</span>
        </label>

        <button type="submit" class="btn btn-primary btn-block" id="login-btn"
                data-loading="Logging in…" @disabled($lockSeconds > 0)>Log in</button>
    </form>

    <p class="switch">New here? <a href="{{ route('register') }}">Create an account</a></p>
@endsection
