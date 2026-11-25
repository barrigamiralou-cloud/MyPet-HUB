<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard · {{ config('app.name', 'MyPet HUB') }}</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="dash-body" data-protected>
    <header class="topbar">
        <span class="brand">{{ config('app.name', 'MyPet HUB') }}</span>

        <div class="topbar-right">
            <span class="who">{{ $user->name }} <small>&#64;{{ $user->username }}</small></span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-ghost btn-sm">Log out</button>
            </form>
        </div>
    </header>

    <main class="dash">
        <h1>Hi, {{ $user->profile?->first_name ?: $user->name }}.</h1>

        @if (session('status'))
            <div class="notice">{{ session('status') }}</div>
        @endif

        <section class="stats">
            <div class="stat"><b>{{ $user->pets->count() }}</b><span>Pets</span></div>
            <div class="stat"><b>{{ $user->businesses->count() }}</b><span>Businesses</span></div>
            <div class="stat"><b>{{ $user->businesses->where('pivot.active', true)->count() }}</b><span>Active</span></div>
        </section>

        <div class="grid">
            {{-- PROFILE: User hasOne Profile --}}
            <section class="card">
                <h2>Profile</h2>
                <form method="POST" action="{{ route('profile.update') }}" class="form" data-once>
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <label class="field">
                            <span>First name</span>
                            <input type="text" name="first_name" value="{{ old('first_name', $user->profile?->first_name) }}">
                            @error('first_name') <small class="error">{{ $message }}</small> @enderror
                        </label>
                        <label class="field">
                            <span>Last name</span>
                            <input type="text" name="last_name" value="{{ old('last_name', $user->profile?->last_name) }}">
                            @error('last_name') <small class="error">{{ $message }}</small> @enderror
                        </label>
                    </div>

                    <label class="field">
                        <span>Birth date</span>
                        <input type="date" name="birth_date" value="{{ old('birth_date', $user->profile?->birth_date?->format('Y-m-d') ?? $user->profile?->birth_date) }}">
                        @error('birth_date') <small class="error">{{ $message }}</small> @enderror
                    </label>

                    <label class="field">
                        <span>Bio</span>
                        <textarea name="bio" rows="3">{{ old('bio', $user->profile?->bio) }}</textarea>
                        @error('bio') <small class="error">{{ $message }}</small> @enderror
                    </label>

                    <button type="submit" class="btn btn-primary" data-loading="Saving…">Save profile</button>
                </form>
            </section>

            {{-- PETS: User hasMany Pet --}}
            <section class="card">
                <h2>Pets</h2>

                <form method="POST" action="{{ route('pets.store') }}" class="form inline" data-once>
                    @csrf
                    <input type="hidden" name="_once" value="{{ \App\Support\Once::issue() }}">

                    <label class="field">
                        <span>Name</span>
                        <input type="text" name="name" value="{{ old('name') }}" required>
                        @error('name') <small class="error">{{ $message }}</small> @enderror
                    </label>
                    <label class="field">
                        <span>Type</span>
                        <input type="text" name="type" value="{{ old('type') }}" placeholder="Cat, dog…" required>
                        @error('type') <small class="error">{{ $message }}</small> @enderror
                    </label>
                    <button type="submit" class="btn btn-primary" data-loading="Adding…">Add</button>
                </form>

                <ul class="list">
                    @forelse ($user->pets as $pet)
                        <li>
                            <div><b>{{ $pet->name }}</b> <small>{{ $pet->type }}</small></div>
                            <form method="POST" action="{{ route('pets.destroy', $pet) }}" data-once>
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="link-danger" data-loading="…">Remove</button>
                            </form>
                        </li>
                    @empty
                        <li class="empty">No pets yet.</li>
                    @endforelse
                </ul>
            </section>

            {{-- BUSINESSES: User belongsToMany Business (pivot: active) --}}
            <section class="card wide">
                <h2>Businesses</h2>

                <form method="POST" action="{{ route('businesses.store') }}" class="form inline" data-once>
                    @csrf
                    <input type="hidden" name="_once" value="{{ \App\Support\Once::issue() }}">

                    <label class="field">
                        <span>Business name</span>
                        <input type="text" name="business_name" value="{{ old('business_name') }}" required>
                        @error('business_name') <small class="error">{{ $message }}</small> @enderror
                    </label>
                    <label class="field grow">
                        <span>Description</span>
                        <input type="text" name="business_description" value="{{ old('business_description') }}">
                    </label>
                    <button type="submit" class="btn btn-primary" data-loading="Creating…">Create</button>
                </form>

                <ul class="list">
                    @forelse ($user->businesses as $business)
                        <li>
                            <div>
                                <b>{{ $business->name }}</b>
                                <span class="pill {{ $business->pivot->active ? 'on' : 'off' }}">
                                    {{ $business->pivot->active ? 'Active' : 'Inactive' }}
                                </span>
                                @if ($business->description)<small>{{ $business->description }}</small>@endif
                            </div>
                            <form method="POST" action="{{ route('businesses.toggle', $business) }}" data-once>
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="link" data-loading="…">
                                    {{ $business->pivot->active ? 'Deactivate' : 'Activate' }}
                                </button>
                            </form>
                        </li>
                    @empty
                        <li class="empty">No businesses yet.</li>
                    @endforelse
                </ul>
            </section>
        </div>
    </main>

    <script src="{{ asset('js/app.js') }}" defer></script>
</body>
</html>
