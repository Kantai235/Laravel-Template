<?php

namespace App\Domains\Auth\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

class UserTypeCheck
{
    public function handle(Request $request, Closure $next, $type): Redirector|RedirectResponse
    {
        if ($request->user()) {
            if (strpos($type, '|') !== false) {
                $types = explode('|', $type);

                foreach ($types as $t) {
                    if ($request->user()->isType($t)) {
                        return $next($request);
                    }
                }
            } elseif ($request->user()->isType($type)) {
                return $next($request);
            }
        }

        return redirect()
            ->route('frontend.index')
            ->withFlashDanger(__('You do not have access to do that.'));
    }
}
