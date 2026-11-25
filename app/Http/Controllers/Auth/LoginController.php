<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function create(): View
    {
        // Set by LoginRequest when the account/IP is locked, so the page can count down.
        return view('auth.login', ['lockSeconds' => (int) session('lock_seconds', 0)]);
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        // New session id after login (prevents session fixation).
        $request->session()->regenerate();

        return redirect()->intended(route('dashboard'));
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('status', 'You have been logged out.');
    }
}
