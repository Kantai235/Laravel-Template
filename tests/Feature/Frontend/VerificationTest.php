<?php

namespace Tests\Feature\Frontend;

use App\Domains\Auth\Models\User;
use App\Domains\Auth\Notifications\Frontend\VerifyEmail;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

/**
 * Class VerificationTest.
 */
class VerificationTest extends TestCase
{
    /** @test */
    public function anUnverifiedUserCannotAccessDashboard()
    {
        $user = User::factory()->unconfirmed()->create();

        $this->actingAs($user);

        $this->get('/dashboard')->assertRedirect('/email/verify');
    }

    /** @test */
    public function anUnverifiedUserCannotAccessAccount()
    {
        $user = User::factory()->unconfirmed()->create();

        $this->actingAs($user);

        $this->get('/account')->assertRedirect('/email/verify');
    }

    /** @test */
    public function aUserCanResendTheVerificationEmail()
    {
        Notification::fake();

        $user = User::factory()->unconfirmed()->create();

        $this->actingAs($user);

        $this->get('/account')->assertRedirect('/email/verify');

        $this->post('/email/resend');

        Notification::assertSentTo($user, VerifyEmail::class);
    }
}
