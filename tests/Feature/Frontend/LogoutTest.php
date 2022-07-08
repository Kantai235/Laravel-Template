<?php

namespace Tests\Feature\Frontend;

use App\Domains\Auth\Models\User;
use Tests\TestCase;

/**
 * Class LogoutTest.
 */
class LogoutTest extends TestCase
{
    /** @test */
    public function theUserCanLogout()
    {
        $this->actingAs($user = User::factory()->create());

        $this->assertAuthenticatedAs($user);

        $this->post('/logout')->assertRedirect('/');

        $this->assertFalse($this->isAuthenticated());
    }
}
