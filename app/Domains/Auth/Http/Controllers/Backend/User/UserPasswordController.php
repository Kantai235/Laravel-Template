<?php

namespace App\Domains\Auth\Http\Controllers\Backend\User;

use App\Domains\Auth\Http\Requests\Backend\User\EditUserPasswordRequest;
use App\Domains\Auth\Http\Requests\Backend\User\UpdateUserPasswordRequest;
use App\Domains\Auth\Models\User;
use App\Domains\Auth\Services\UserService;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class UserPasswordController
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function edit(EditUserPasswordRequest $request, User $user): View|ViewFactory
    {
        return view('backend.auth.user.change-password')
            ->with('user', $user);
    }

    public function update(UpdateUserPasswordRequest $request, User $user): Redirector|RedirectResponse
    {
        $this->userService->updatePassword($user, $request->validated());

        return redirect()
            ->route('admin.auth.user.index')
            ->withFlashSuccess(__('The user\'s password was successfully updated.'));
    }
}
