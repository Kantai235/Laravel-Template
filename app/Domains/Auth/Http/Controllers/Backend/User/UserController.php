<?php

namespace App\Domains\Auth\Http\Controllers\Backend\User;

use App\Domains\Auth\Http\Requests\Backend\User\DeleteUserRequest;
use App\Domains\Auth\Http\Requests\Backend\User\EditUserRequest;
use App\Domains\Auth\Http\Requests\Backend\User\StoreUserRequest;
use App\Domains\Auth\Http\Requests\Backend\User\UpdateUserRequest;
use App\Domains\Auth\Models\User;
use App\Domains\Auth\Services\PermissionService;
use App\Domains\Auth\Services\RoleService;
use App\Domains\Auth\Services\UserService;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class UserController
{
    protected UserService $userService;

    protected RoleService $roleService;

    protected PermissionService $permissionService;

    public function __construct(
        UserService $userService,
        RoleService $roleService,
        PermissionService $permissionService
    ) {
        $this->userService = $userService;
        $this->roleService = $roleService;
        $this->permissionService = $permissionService;
    }

    public function index(): View|ViewFactory
    {
        return view('backend.auth.user.index');
    }

    public function create(): View|ViewFactory
    {
        return view('backend.auth.user.create')
            ->with('roles', $this->roleService->get())
            ->with('categories', $this->permissionService->getCategorizedPermissions())
            ->with('general', $this->permissionService->getUncategorizedPermissions());
    }

    public function store(StoreUserRequest $request): Redirector|RedirectResponse
    {
        $user = $this->userService->store($request->validated());

        return redirect()
            ->route('admin.auth.user.show', $user)
            ->withFlashSuccess(__('The user was successfully created.'));
    }

    public function show(User $user): View|ViewFactory
    {
        return view('backend.auth.user.show')
            ->with('user', $user);
    }

    public function edit(EditUserRequest $request, User $user): View|ViewFactory
    {
        return view('backend.auth.user.edit')
            ->with('user', $user)
            ->with('roles', $this->roleService->get())
            ->with('categories', $this->permissionService->getCategorizedPermissions())
            ->with('general', $this->permissionService->getUncategorizedPermissions())
            ->with('usedPermissions', $user->permissions->modelKeys());
    }

    public function update(UpdateUserRequest $request, User $user): Redirector|RedirectResponse
    {
        $this->userService->update($user, $request->validated());

        return redirect()
            ->route('admin.auth.user.show', $user)
            ->withFlashSuccess(__('The user was successfully updated.'));
    }

    public function destroy(DeleteUserRequest $request, User $user): Redirector|RedirectResponse
    {
        $this->userService->delete($user);

        return redirect()
            ->route('admin.auth.user.deleted')
            ->withFlashSuccess(__('The user was successfully deleted.'));
    }
}
