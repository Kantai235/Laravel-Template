<?php

namespace App\Domains\Auth\Http\Controllers\Frontend\Auth;

use App\Domains\Auth\Http\Requests\Frontend\Auth\DisableTwoFactorAuthenticationRequest;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class DisableTwoFactorAuthenticationController
{
    public function show(): View|ViewFactory
    {
        return view('frontend.user.account.tabs.two-factor-authentication.disable');
    }

    public function destroy(DisableTwoFactorAuthenticationRequest $request): Redirector|RedirectResponse
    {
        $request->user()->disableTwoFactorAuth();

        return redirect()
            ->route('frontend.user.account', ['#two-factor-authentication'])
            ->withFlashSuccess(__('Two Factor Authentication Successfully Disabled'));
    }
}
