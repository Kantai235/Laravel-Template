<?php

namespace App\Domains\Auth\Http\Controllers\Backend\Role;

use App\Domains\Auth\Http\Requests\Backend\Role\DeleteRoleRequest;
use App\Domains\Auth\Http\Requests\Backend\Role\EditRoleRequest;
use App\Domains\Auth\Http\Requests\Backend\Role\StoreRoleRequest;
use App\Domains\Auth\Http\Requests\Backend\Role\UpdateRoleRequest;
use App\Domains\Auth\Models\Role;
use App\Domains\Auth\Services\PermissionService;
use App\Domains\Auth\Services\RoleService;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class RoleController
{
    protected RoleService $roleService;

    protected PermissionService $permissionService;

    public function __construct(RoleService $roleService, PermissionService $permissionService)
    {
        $this->roleService = $roleService;
        $this->permissionService = $permissionService;
    }

    public function index(): View|ViewFactory
    {
        return view('backend.auth.role.index');
    }

    public function create(): View|ViewFactory
    {
        return view('backend.auth.role.create')
            ->with('categories', $this->permissionService->getCategorizedPermissions())
            ->with('general', $this->permissionService->getUncategorizedPermissions());
    }

    public function store(StoreRoleRequest $request): Redirector|RedirectResponse
    {
        $this->roleService->store($request->validated());

        return redirect()
            ->route('admin.auth.role.index')
            ->withFlashSuccess(__('The role was successfully created.'));
    }

    public function edit(EditRoleRequest $request, Role $role): View|ViewFactory
    {
        return view('backend.auth.role.edit')
            ->with('categories', $this->permissionService->getCategorizedPermissions())
            ->with('general', $this->permissionService->getUncategorizedPermissions())
            ->with('role', $role)
            ->with('usedPermissions', $role->permissions->modelKeys());
    }

    public function update(UpdateRoleRequest $request, Role $role): Redirector|RedirectResponse
    {
        $this->roleService->update($role, $request->validated());

        return redirect()
            ->route('admin.auth.role.index')
            ->withFlashSuccess(__('The role was successfully updated.'));
    }

    public function destroy(DeleteRoleRequest $request, Role $role): Redirector|RedirectResponse
    {
        $this->roleService->destroy($role);

        return redirect()
            ->route('admin.auth.role.index')
            ->withFlashSuccess(__('The role was successfully deleted.'));
    }
}
