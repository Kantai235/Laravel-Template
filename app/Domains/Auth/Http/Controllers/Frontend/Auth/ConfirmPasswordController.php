<?php

namespace App\Domains\Auth\Http\Controllers\Frontend\Auth;

use App\Providers\RouteServiceProvider;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\ConfirmsPasswords;

class ConfirmPasswordController
{
    /*
    |--------------------------------------------------------------------------
    | Confirm Password Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password confirmations and
    | uses a simple trait to include the behavior. You're free to explore
    | this trait and override any functions that require customization.
    |
    */

    use ConfirmsPasswords;

    /**
     * Where to redirect users when the intended url fails.
     */
    protected string $redirectTo = RouteServiceProvider::HOME;

    /**
     * Display the password confirmation view.
     */
    public function showConfirmForm(): View|ViewFactory
    {
        return view('frontend.auth.passwords.confirm');
    }
}
