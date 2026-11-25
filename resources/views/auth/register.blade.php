@extends('layouts.auth')

@section('title', 'Register')

@section('content')
    <h1>Create an account</h1>
    <p class="lead">It only takes a minute.</p>

    <form method="POST" action="{{ route('register.store') }}" class="form" data-once>
        @csrf
        <input type="hidden" name="_once" value="{{ \App\Support\Once::issue() }}">

        <label class="field">
            <span>Full name</span>
            <input type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name">
            @error('name') <small class="error">{{ $message }}</small> @enderror
        </label>

        <div class="row">
            <label class="field">
                <span>Username</span>
                <input type="text" name="username" value="{{ old('username') }}" required autocomplete="username">
                @error('username') <small class="error">{{ $message }}</small> @enderror
            </label>

            <label class="field">
                <span>Email</span>
                <input type="email" name="email" value="{{ old('email') }}" required autocomplete="email">
                @error('email') <small class="error">{{ $message }}</small> @enderror
            </label>
        </div>

        <div class="row">
            <label class="field">
                <span>Password</span>
                <input type="password" name="password" required autocomplete="new-password">
                @error('password') <small class="error">{{ $message }}</small> @enderror
            </label>

            <label class="field">
                <span>Confirm password</span>
                <input type="password" name="password_confirmation" required autocomplete="new-password">
            </label>
        </div>

        <button type="submit" class="btn btn-primary btn-block" data-loading="Creating account…">Create account</button>
    </form>

    <p class="switch">Already have an account? <a href="{{ route('login') }}">Log in</a></p>
@endsection
