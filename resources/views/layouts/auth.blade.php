<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') · {{ config('app.name', 'MyPet HUB') }}</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="auth-body">
    <main class="auth-panel">
        <a href="{{ route('welcome') }}" class="brand">{{ config('app.name', 'MyPet HUB') }}</a>

        <div class="auth-content">
            @yield('content')
        </div>

        <p class="auth-foot">&copy; {{ date('Y') }} {{ config('app.name', 'MyPet HUB') }}</p>
    </main>

    <script src="{{ asset('js/app.js') }}" defer></script>
</body>
</html>
