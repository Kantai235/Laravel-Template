<?php

namespace Tests\Feature\Frontend;

use App\Domains\Auth\Models\User;
use Tests\TestCase;

/**
 * Class ConfirmationTest.
 */
class ConfirmationTest extends TestCase
{
    /** @test */
    public function aUserCanAccessTheConfirmPasswordPage()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $this->get('/password/confirm')->assertOk();
    }
}
