<?php

namespace Tests\Feature\Backend\Role;

use App\Domains\Auth\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class ReadRolesTest.
 */
class ListRoleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function anAdminCanAccessTheRoleIndexPage()
    {
        $this->loginAsAdmin();

        $this->get('/admin/auth/role')->assertOk();
    }

    /** @test */
    public function onlyAdminCanViewRoles()
    {
        $this->actingAs(User::factory()->admin()->create());

        $response = $this->get('/admin/auth/role');

        $response->assertSessionHas('flash_danger', __('You do not have access to do that.'));
    }
}
