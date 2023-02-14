<?php

namespace App\Domains\Auth\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ToBeLoggedOut
{
    public function handle(Request $request, Closure $next)
    {
        // If the user is to be logged out
        if ($request->user() && $request->user()->to_be_logged_out) {
            // Make sure they can log back in next session
            $request->user()->update(['to_be_logged_out' => false]);

            // Kill the current session and force back to the login screen
            session()->flush();
            auth()->logout();

            return redirect()->route('frontend.auth.login');
        }

        return $next($request);
    }
}
