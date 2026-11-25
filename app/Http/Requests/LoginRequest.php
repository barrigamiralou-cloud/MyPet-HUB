<?php

namespace App\Http\Requests;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /** Wrong attempts allowed before the account/IP is locked. */
    public const MAX_ATTEMPTS = 5;

    /** Lock duration in seconds. */
    public const LOCK_SECONDS = 60;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'login'    => ['required', 'string'],   // username OR email
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Try to log in. Counts every failure and locks after MAX_ATTEMPTS.
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        $field = filter_var($this->input('login'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $ok = Auth::attempt(
            [$field => $this->input('login'), 'password' => $this->input('password')],
            $this->boolean('remember')
        );

        if (! $ok) {
            RateLimiter::hit($this->throttleKey(), self::LOCK_SECONDS);

            $left = max(0, self::MAX_ATTEMPTS - RateLimiter::attempts($this->throttleKey()));

            if ($left === 0) {
                // 5th wrong password: lock right away and tell the page how long.
                session()->flash('lock_seconds', RateLimiter::availableIn($this->throttleKey()));
            }

            throw ValidationException::withMessages([
                'login' => $left > 0
                    ? "These credentials do not match our records. {$left} attempt(s) left."
                    : 'Too many attempts. Your login is locked for a moment.',
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Block the request if the limit has been reached.
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), self::MAX_ATTEMPTS)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        session()->flash('lock_seconds', $seconds);

        throw ValidationException::withMessages([
            'login' => "Too many login attempts. Try again in {$seconds} seconds.",
        ])->status(429);
    }

    /**
     * Key = typed username/email + IP, so guessing from one device is blocked
     * and so is guessing a single account.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->input('login')).'|'.$this->ip());
    }
}
