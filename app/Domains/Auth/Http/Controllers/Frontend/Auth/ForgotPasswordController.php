<?php

namespace App\Domains\Auth\Http\Controllers\Frontend\Auth;

use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgotPasswordController
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Display the form to request a password reset link.
     */
    public function showLinkRequestForm(): View|ViewFactory
    {
        return view('frontend.auth.passwords.email');
    }
}
