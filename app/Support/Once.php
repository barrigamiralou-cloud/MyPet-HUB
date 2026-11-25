<?php

namespace App\Support;

use Illuminate\Support\Str;

/**
 * One-time form tokens.
 *
 * Every form that creates data gets its own token (see the @once-token usage in the views).
 * The first request that carries the token consumes it; any later request with the same
 * token (double click, double tab, replay) is rejected, so no duplicate record is created.
 */
class Once
{
    private const KEY = 'once_tokens';

    /** Create a token and remember it in the session. */
    public static function issue(): string
    {
        $token = Str::random(40);

        $tokens = session(self::KEY, []);
        $tokens[$token] = true;

        // Keep the session small: only the newest 50 tokens.
        session([self::KEY => array_slice($tokens, -50, null, true)]);

        return $token;
    }

    /**
     * Returns true only the FIRST time a valid token is used.
     */
    public static function consume(?string $token): bool
    {
        if (! $token) {
            return false;
        }

        $tokens = session(self::KEY, []);

        if (! isset($tokens[$token])) {
            return false;
        }

        unset($tokens[$token]);
        session([self::KEY => $tokens]);

        return true;
    }
}
