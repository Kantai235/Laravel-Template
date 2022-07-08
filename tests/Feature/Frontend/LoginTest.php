<?php

namespace Tests\Feature\Frontend;

use App\Domains\Auth\Events\User\UserLoggedIn;
use App\Domains\Auth\Models\User;
use Illuminate\Support\Facades\Event;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

/**
 * Class LoginTest.
 */
class LoginTest extends TestCase
{
    /** @test */
    public function theLoginRouteExists()
    {
        $this->get('/login')->assertStatus(200);
    }

    /** @test */
    public function loginRequiresValidation()
    {
        $response = $this->post('/login');

        $response->assertSessionHasErrors(['email', 'password']);
    }

    /** @test */
    public function aUserCanLoginWithEmailAndPassword()
    {
        Event::fake();

        $user = User::factory()->create([
            'email' => 'john@example.com',
            'password' => 'secret',
        ]);

        $this->post('/login', [
            'email' => 'john@example.com',
            'password' => 'secret',
        ])->assertRedirect(route(homeRoute()));

        Event::assertDispatched(function (UserLoggedIn $event) use ($user) {
            return $event->user->id === $user->id;
        });

        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function inactiveUsersCantLogin()
    {
        User::factory()->inactive()->create([
            'email' => 'john@example.com',
            'password' => 'secret',
        ]);

        $response = $this->post('/login', [
            'email' => 'john@example.com',
            'password' => 'secret',
        ]);

        $response->assertSessionHas('flash_danger', __('Your account has been deactivated.'));
        $this->assertFalse($this->isAuthenticated());
    }

    /** @test */
    public function cantLoginWithInvalidCredentials()
    {
        $this->withoutExceptionHandling();
        $this->expectException(ValidationException::class);

        $response = $this->post('/login', [
            'email' => 'not-existend@user.com',
            'password' => '9s8gy8s9diguh4iev',
        ]);

        $response->assertSessionHas('flash_danger', __('These credentials do not match our records.'));
        $this->assertFalse($this->isAuthenticated());
    }

    /** @test */
    public function aUsersIpAndLoginTimeIsUpdatedOnLogin()
    {
        $user = User::factory()->create([
            'email' => 'john@example.com',
            'password' => 'secret',
            'last_login_at' => null,
            'last_login_ip' => null,
        ]);

        $this->post('/login', [
            'email' => 'john@example.com',
            'password' => 'secret',
        ]);

        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
            'last_login_at' => null,
            'last_login_ip' => null,
        ]);
    }

    /** @test */
    public function aUserCanLogOut()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post('/logout')
            ->assertRedirect('/');

        $this->assertFalse($this->isAuthenticated());
    }
}
