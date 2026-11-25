@extends('layouts.auth')

@section('title', 'Welcome')

@section('content')
    <h1>Hello, there.</h1>
    <p class="lead">A quiet place to keep track of your profile, your pets and the businesses you belong to.</p>

    <div class="actions">
        <a href="{{ route('login') }}" class="btn btn-primary">Log in</a>
        <a href="{{ route('register') }}" class="btn btn-ghost">Create an account</a>
    </div>
@endsection
