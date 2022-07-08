<?php

namespace Tests\Feature\Backend\Role;

use App\Domains\Auth\Events\Role\RoleCreated;
use App\Domains\Auth\Models\Permission;
use App\Domains\Auth\Models\Role;
use App\Domains\Auth\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

/**
 * Class CreateRoleTest.
 */
class CreateRoleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function anAdminCanAccessTheCreateRolePage()
    {
        $this->loginAsAdmin();

        $this->get('/admin/auth/role/create')->assertOk();
    }

    /** @test */
    public function createRoleRequiresValidation()
    {
        $this->loginAsAdmin();

        $response = $this->post('/admin/auth/role');

        $response->assertSessionHasErrors('type', 'name');
    }

    /** @test */
    public function theNameMustBeUnique()
    {
        $this->loginAsAdmin();

        $response = $this->post('/admin/auth/role', ['name' => config('template.access.role.admin')]);

        $response->assertSessionHasErrors('name');
    }

    /** @test */
    public function aRoleCanBeCreated()
    {
        Event::fake();

        $this->loginAsAdmin();

        $this->post('/admin/auth/role', [
            'type' => User::TYPE_ADMIN,
            'name' => 'new role',
            'permissions' => [
                Permission::whereName('admin.access.user.list')->first()->id,
            ],
        ]);

        $this->assertDatabaseHas('roles', [
            'type' => User::TYPE_ADMIN,
            'name' => 'new role',
        ]);

        $this->assertDatabaseHas('role_has_permissions', [
            'permission_id' => Permission::whereName('admin.access.user.list')->first()->id,
            'role_id' => Role::whereName('new role')->first()->id,
        ]);

        Event::assertDispatched(RoleCreated::class);
    }

    /** @test */
    public function onlyAdminCanCreateRoles()
    {
        $this->actingAs(User::factory()->admin()->create());

        $response = $this->get('/admin/auth/role/create');

        $response->assertSessionHas('flash_danger', __('You do not have access to do that.'));
    }
}
