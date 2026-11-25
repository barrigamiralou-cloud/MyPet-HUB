<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\User;
use App\Support\Once;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class RegisterController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'alpha_dash', 'min:3', 'max:30', 'unique:users,username'],
            'email'    => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::min(8)->letters()->numbers()],
        ]);

        // Double click / replay: the token was already used, so do nothing.
        if (! Once::consume($request->input('_once'))) {
            return redirect()->route('login');
        }

        $user = DB::transaction(function () use ($data) {
            // Uses the User model ($fillable + 'hashed' cast hashes the password).
            $user = User::create($data);

            // hasOne(Profile): create an empty profile for the new user.
            $user->profile()->create([
                'first_name' => str($data['name'])->before(' ')->toString(),
                'last_name'  => str($data['name'])->contains(' ') ? str($data['name'])->after(' ')->toString() : null,
            ]);

            return $user;
        });

        Auth::login($user);
        $request->session()->regenerate();

        // Redirect after POST (PRG): refreshing the page can't re-submit the form.
        return redirect()->route('dashboard')->with('status', 'Welcome! Your account is ready.');
    }
}
