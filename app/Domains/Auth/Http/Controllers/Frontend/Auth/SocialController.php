<?php

namespace App\Domains\Auth\Http\Controllers\Frontend\Auth;

use App\Domains\Auth\Events\User\UserLoggedIn;
use App\Domains\Auth\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Laravel\Socialite\Facades\Socialite;

class SocialController
{
    public function redirect($provider): Redirector|RedirectResponse
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback(string $provider, UserService $userService): Redirector|RedirectResponse
    {
        $user = $userService->registerProvider(Socialite::driver($provider)->user(), $provider);

        if (!$user->isActive()) {
            auth()->logout();

            return redirect()
                ->route('frontend.auth.login')
                ->withFlashDanger(__('Your account has been deactivated.'));
        }

        auth()->login($user);

        event(new UserLoggedIn($user));

        return redirect()->route(homeRoute());
    }
}
