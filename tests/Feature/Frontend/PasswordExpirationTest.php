<?php

namespace Tests\Feature\Frontend;

use App\Domains\Auth\Models\User;
use Tests\TestCase;

/**
 * Class PasswordExpirationTest.
 */
class PasswordExpirationTest extends TestCase
{
    /** @test */
    public function aUserCanAccessThePasswordExpired()
    {
        config(['template.access.user.password_expires_days' => 30]);

        $user = User::factory()->create();

        $this->actingAs($user);

        $this->get('/password/expired')->assertOk();
    }

    /** @test */
    public function aUserWithAnExpiredPasswordCannotAccessDashboard()
    {
        $user = User::factory()->passwordExpired()->create();

        $this->actingAs($user);

        $response = $this->get('/dashboard')->assertRedirect('/password/expired');

        // phpcs:disable
        $response->assertSessionHas('flash_warning', __('Your password has expired. We require you to change your password every :days days for security purposes.', [
            'days' => config('template.access.user.password_expires_days'),
        ]));
    }

    /** @test */
    public function aUserWithAnExpiredPasswordCannotAccessAccount()
    {
        $user = User::factory()->passwordExpired()->create();

        $this->actingAs($user);

        $response = $this->get('/account')->assertRedirect('/password/expired');

        $response->assertSessionHas('flash_warning', __('Your password has expired. We require you to change your password every :days days for security purposes.', [
            'days' => config('template.access.user.password_expires_days'),
        ]));
    }

    /** @test */
    public function passwordExpirationUpdateRequiresValidation()
    {
        $this->actingAs(User::factory()->create());

        $response = $this->patch('/password/expired');

        $response->assertSessionHasErrors(['current_password', 'password']);
    }

    /** @test */
    public function aUserCanUpdateTheirExpiredPassword()
    {
        $user = User::factory()->passwordExpired()->create();

        $this->actingAs($user);

        $this->get('/account')->assertRedirect('/password/expired');

        $response = $this->patch('/password/expired', [
            'current_password' => '1234',
            'password' => 'OC4Nzu270N!QBVi%U%qX',
            'password_confirmation' => 'OC4Nzu270N!QBVi%U%qX',
        ])->assertRedirect('/account');

        $response->assertSessionHas('flash_success', __('Password successfully updated.'));

        $this->get('/account')->assertOk();
    }
}
