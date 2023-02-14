<?php

namespace App\Domains\Auth\Http\Controllers\Frontend\Auth;

use App\Domains\Auth\Http\Requests\Frontend\Auth\UpdatePasswordRequest;
use App\Domains\Auth\Services\UserService;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class PasswordExpiredController
{
    public function expired(): View|ViewFactory
    {
        abort_unless(config('template.access.user.password_expires_days'), 404);

        return view('frontend.auth.passwords.expired');
    }

    public function update(UpdatePasswordRequest $request, UserService $userService): Redirector|RedirectResponse
    {
        abort_unless(config('template.access.user.password_expires_days'), 404);

        $userService->updatePassword($request->user(), $request->only('old_password', 'password'), true);

        return redirect()
            ->route('frontend.user.account')
            ->withFlashSuccess(__('Password successfully updated.'));
    }
}
