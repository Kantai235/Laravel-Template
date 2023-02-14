<?php

namespace App\Domains\Auth\Http\Controllers\Backend\User;

use App\Domains\Auth\Models\User;
use App\Domains\Auth\Services\UserService;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

class DeactivatedUserController
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(): View|ViewFactory
    {
        return view('backend.auth.user.deactivated');
    }

    public function update(Request $request, User $user, int $status): Redirector|RedirectResponse
    {
        $this->userService->mark($user, $status);

        return redirect()->route(
            $status === 1 || !$request->user()->can('admin.access.user.reactivate')
                ? 'admin.auth.user.index'
                : 'admin.auth.user.deactivated'
        )->withFlashSuccess(__('The user was successfully updated.'));
    }
}
