<?php

namespace Tests\Feature\Frontend;

use App\Domains\Auth\Models\User;
use Tests\TestCase;

/**
 * Class DashboardTest.
 */
class DashboardTest extends TestCase
{
    /** @test */
    public function only_authenticated_users_can_access_their_account()
    {
        $this->get('/dashboard')->assertRedirect('/login');

        /** @var User */
        $user = User::factory()->user()->create();

        $this->actingAs($user);

        $this->get('/dashboard')->assertOk();
    }
}
