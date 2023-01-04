<?php

namespace App\Domains\Auth\Http\Controllers\Backend\User;

use App\Domains\Auth\Models\User;
use App\Domains\Auth\Services\UserService;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class DeletedUserController
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(): View|ViewFactory
    {
        return view('backend.auth.user.deleted');
    }

    public function update(User $deletedUser): Redirector|RedirectResponse
    {
        $this->userService->restore($deletedUser);

        return redirect()
            ->route('admin.auth.user.index')
            ->withFlashSuccess(__('The user was successfully restored.'));
    }

    public function destroy(User $deletedUser): Redirector|RedirectResponse
    {
        abort_unless(config('template.access.user.permanently_delete'), 404);

        $this->userService->destroy($deletedUser);

        return redirect()
            ->route('admin.auth.user.deleted')
            ->withFlashSuccess(__('The user was permanently deleted.'));
    }
}
