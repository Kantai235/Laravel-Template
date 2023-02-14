<?php

namespace App\Domains\Auth\Http\Controllers\Frontend\Auth;

use App\Domains\Auth\Http\Requests\Frontend\Auth\UpdatePasswordRequest;
use App\Domains\Auth\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class UpdatePasswordController
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function update(UpdatePasswordRequest $request): Redirector|RedirectResponse
    {
        $this->userService->updatePassword($request->user(), $request->validated());

        return redirect()
            ->route('frontend.user.account', ['#password'])
            ->withFlashSuccess(__('Password successfully updated.'));
    }
}
