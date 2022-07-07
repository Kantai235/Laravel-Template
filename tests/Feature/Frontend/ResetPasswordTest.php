<?php

namespace Tests\Feature\Frontend;

use App\Domains\Auth\Models\User;
use App\Domains\Auth\Notifications\Frontend\ResetPasswordNotification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

/**
 * Class ResetPasswordTest.
 */
class ResetPasswordTest extends TestCase
{
    /** @test */
    public function thePasswordResetRouteExists()
    {
        $this->get('password/reset')->assertOk();
    }

    /** @test */
    public function passwordResetRequiresValidation()
    {
        $response = $this->post('/password/email');

        $response->assertSessionHasErrors('email');
    }

    /** @test */
    public function aNotificationGetsSentIfPasswordResetIsRequested()
    {
        Notification::fake();

        $user = User::factory()->create(['email' => 'john@example.com']);

        $this->post('password/email', ['email' => 'john@example.com']);

        Notification::assertSentTo($user, ResetPasswordNotification::class);
    }

    /** @test */
    public function theResetPasswordFormHasRequiredFields()
    {
        $response = $this->post('password/reset', [
            'token' => '',
            'email' => '',
            'password' => '',
            'password_confirmation' => '',
        ]);

        $response->assertSessionHasErrors(['token', 'email', 'password']);
    }

    /** @test */
    public function aPasswordCanBeReset()
    {
        $user = User::factory()->create(['email' => 'john@example.com']);

        $token = $this->app->make('auth.password.broker')->createToken($user);

        $this->post('password/reset', [
            'token' => $token,
            'email' => 'john@example.com',
            'password' => ']EqZL4}zBT',
            'password_confirmation' => ']EqZL4}zBT',
        ]);

        $this->assertTrue(Hash::check(']EqZL4}zBT', $user->fresh()->password));
    }

    /** @test */
    public function thePasswordCanBeValidated()
    {
        $user = User::factory()->create(['email' => 'john@example.com']);

        $token = $this->app->make('auth.password.broker')->createToken($user);

        $response = $this->followingRedirects()
            ->post('password/reset', [
                'token' => $token,
                'email' => 'john@example.com',
                'password' => 'secret',
                'password_confirmation' => 'secret',
            ]);

        $this->assertStringContainsString(__('validation.min.string', [
            'attribute' => __('password'),
            'min' => 8,
        ]), $response->content());
    }

    /** @test */
    public function aUserCanUseTheSamePasswordWhenHistoryIsOffOnPasswordReset()
    {
        config(['template.access.user.password_history' => false]);

        $user = User::factory()->create(['email' => 'john@example.com', 'password' => ']EqZL4}zBT']);

        $token = $this->app->make('auth.password.broker')->createToken($user);

        $response = $this->followingRedirects()
            ->post('password/reset', [
                'token' => $token,
                'email' => 'john@example.com',
                'password' => ']EqZL4}zBT',
                'password_confirmation' => ']EqZL4}zBT',
            ]);

        $this->assertStringContainsString(__('passwords.reset'), $response->content());
        $this->assertTrue(Hash::check(']EqZL4}zBT', $user->fresh()->password));
    }

    /** @test */
    public function aUserCanNotUseTheSamePasswordWhenHistoryIsOnOnPasswordReset()
    {
        config(['template.access.user.password_history' => 3]);

        $user = User::factory()->create(['email' => 'john@example.com', 'password' => ']EqZL4}zBT']);

        // Change once
        $this->actingAs($user)
            ->patch('/password/update', [
                'current_password' => ']EqZL4}zBT',
                'password' => ':ZqD~57}1t',
                'password_confirmation' => ':ZqD~57}1t',
            ]);

        $this->assertTrue(Hash::check(':ZqD~57}1t', $user->fresh()->password));

        auth()->logout();

        $token = $this->app->make('auth.password.broker')->createToken($user);

        $response = $this->post('password/reset', [
            'token' => $token,
            'email' => 'john@example.com',
            'password' => ']EqZL4}zBT',
            'password_confirmation' => ']EqZL4}zBT',
        ]);

        $response->assertSessionHasErrors();
        $errors = session('errors');
        $this->assertSame(
            $errors->get('password')[0],
            __('You can not set a password that you have previously used within the last 3 times.')
        );
        $this->assertTrue(Hash::check(':ZqD~57}1t', $user->fresh()->password));
    }
}
