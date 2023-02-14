<?php

namespace App\Domains\Auth\Http\Middleware;

use App\Domains\Auth\Models\User;
use Closure;
use Illuminate\Http\Request;

/**
 * Class AdminCheck.
 */
class AdminCheck
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->user() && $request->user()->isType(User::TYPE_ADMIN)) {
            return $next($request);
        }

        return redirect()
            ->route('frontend.index')
            ->withFlashDanger(__('You do not have access to do that.'));
    }
}
