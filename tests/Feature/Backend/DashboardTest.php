<?php

namespace Tests\Feature\Backend;

use App\Domains\Auth\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class DashboardTest.
 */
class DashboardTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function unauthenticatedUsersCantAccessAdminDashboard()
    {
        $this->get('/admin/dashboard')->assertRedirect('/login');
    }

    /** @test */
    public function notAuthorizedUsersCantAccessAdminDashboard()
    {
        $this->actingAs(User::factory()->user()->create());

        $response = $this->get('/admin/dashboard');

        $response->assertRedirect('/');

        $response->assertSessionHas('flash_danger', __('You do not have access to do that.'));
    }

    /** @test */
    public function adminCanAccessAdminDashboard()
    {
        $this->loginAsAdmin();

        $this->get('/admin/dashboard')->assertOk();
    }
}
