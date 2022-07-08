<?php

namespace Tests\Feature\Backend\Role;

use App\Domains\Auth\Events\Role\RoleDeleted;
use App\Domains\Auth\Models\Role;
use App\Domains\Auth\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

/**
 * Class DeleteRoleTest.
 */
class DeleteRoleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function aRoleCanBeDeleted()
    {
        Event::fake();

        $role = Role::factory()->create();

        $this->loginAsAdmin();

        $this->assertDatabaseHas(config('permission.table_names.roles'), ['id' => $role->id]);

        $this->delete("/admin/auth/role/{$role->id}");

        $this->assertDatabaseMissing(config('permission.table_names.roles'), ['id' => $role->id]);

        Event::assertDispatched(RoleDeleted::class);
    }

    /** @test */
    public function theAdminRoleCanNotBeDeleted()
    {
        $this->loginAsAdmin();

        $role = Role::whereName(config('template.access.role.admin'))->first();

        $response = $this->delete('/admin/auth/role/' . $role->id);

        $response->assertSessionHas(['flash_danger' => __('You can not delete the Administrator role.')]);

        $this->assertDatabaseHas(config('permission.table_names.roles'), ['id' => $role->id]);
    }

    /** @test */
    public function aRoleWithAssignedUsersCantBeDeleted()
    {
        $this->loginAsAdmin();

        $role = Role::factory()->create();
        $user = User::factory()->create();
        $user->assignRole($role);

        $response = $this->delete('/admin/auth/role/' . $role->id);

        $response->assertSessionHas(['flash_danger' => __('You can not delete a role with associated users.')]);

        $this->assertDatabaseHas(config('permission.table_names.roles'), ['id' => $role->id]);
    }

    /** @test */
    public function onlyAdminCanDeleteRoles()
    {
        $this->actingAs(User::factory()->admin()->create());

        $role = Role::factory()->create();

        $response = $this->delete('/admin/auth/role/' . $role->id);

        $response->assertSessionHas('flash_danger', __('You do not have access to do that.'));

        $this->assertDatabaseHas(config('permission.table_names.roles'), ['id' => $role->id]);
    }
}
