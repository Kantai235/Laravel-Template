<?php

namespace App\Domains\Auth\Http\Controllers\Frontend\Auth;

use App\Domains\Auth\Events\User\UserLoggedIn;
use App\Rules\Captcha;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use LangleyFoxall\LaravelNISTPasswordRules\PasswordRules;

class LoginController
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     */
    public function redirectPath(): string
    {
        return route(homeRoute());
    }

    /**
     * Show the application's login form.
     */
    public function showLoginForm(): View|ViewFactory
    {
        return view('frontend.auth.login');
    }

    /**
     * Validate the user login request.
     */
    protected function validateLogin(Request $request): void
    {
        $request->validate([
            $this->username() => ['required', 'max:255', 'string'],
            'password' => array_merge(['max:100'], PasswordRules::login()),
            'g-recaptcha-response' => ['required_if:captcha_status,true', new Captcha],
        ], [
            'g-recaptcha-response.required_if' => __('validation.required', ['attribute' => 'captcha']),
        ]);
    }

    /**
     * Overidden for 2FA
     * https://github.com/Laragear/TwoFactor#logging-in
     *
     * Attempt to log the user into the application.
     */
    protected function attemptLogin(Request $request): bool
    {
        try {
            return $this->guard()->attempt(
                $this->credentials($request),
                $request->filled('remember')
            );
        } catch (HttpResponseException $exception) {
            $this->incrementLoginAttempts($request);

            throw $exception;
        }
    }

    /**
     * The user has been authenticated.
     *
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        if (! $user->isActive()) {
            auth()->logout();

            return redirect()
                ->route('frontend.auth.login')
                ->withFlashDanger(__('Your account has been deactivated.'));
        }

        event(new UserLoggedIn($user));

        if (config('template.access.user.single_login')) {
            auth()->logoutOtherDevices($request->password);
        }
    }
}
