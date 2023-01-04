<?php

namespace App\Domains\Auth\Http\Controllers\Frontend\Auth;

use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

class TwoFactorAuthenticationController
{
    public function create(Request $request): View|ViewFactory
    {
        $secret = $request->user()->createTwoFactorAuth();

        return view('frontend.user.account.tabs.two-factor-authentication.enable')
            ->with('qrCode', $secret->toQr())
            ->with('secret', $secret->toString());
    }

    public function show(Request $request): View|ViewFactory
    {
        return view('frontend.user.account.tabs.two-factor-authentication.recovery')
            ->with('recoveryCodes', $request->user()->getRecoveryCodes());
    }

    public function update(Request $request): Redirector|RedirectResponse
    {
        $request->user()->generateRecoveryCodes();

        session()->flash('flash_warning', __('Any old backup codes have been invalidated.'));

        return redirect()
            ->route('frontend.auth.account.2fa.show')
            ->withFlashSuccess(__('Two Factor Recovery Codes Regenerated'));
    }
}
