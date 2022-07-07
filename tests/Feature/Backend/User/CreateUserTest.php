<?php

namespace Tests\Feature\Backend\User;

use App\Domains\Auth\Events\User\UserCreated;
use App\Domains\Auth\Models\Role;
use App\Domains\Auth\Models\User;
use App\Domains\Auth\Notifications\Frontend\VerifyEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

/**
 * Class CreateUserTest.
 */
class CreateUserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function anAdminCanAccessTheCreateUserPage()
    {
        $this->loginAsAdmin();

        $response = $this->get('/admin/auth/user/create');

        $response->assertOk();
    }

    /** @test */
    public function createUserRequiresValidation()
    {
        $this->loginAsAdmin();

        $response = $this->post('/admin/auth/user');

        $response->assertSessionHasErrors(['type', 'name', 'email', 'password']);
    }

    /** @test */
    public function userEmailNeedsToBeUnique()
    {
        $this->loginAsAdmin();

        User::factory()->create(['email' => 'john@example.com']);

        $response = $this->post('/admin/auth/user', [
            'email' => 'john@example.com',
        ]);

        $response->assertSessionHasErrors('email');
    }

    /** @test */
    public function adminCanCreateNewUser()
    {
        Event::fake();

        $this->loginAsAdmin();

        $response = $this->post('/admin/auth/user', [
            'type' => User::TYPE_ADMIN,
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'OC4Nzu270N!QBVi%U%qX',
            'password_confirmation' => 'OC4Nzu270N!QBVi%U%qX',
            'active' => '1',
            'roles' => [
                Role::whereName(config('template.access.role.admin'))->first()->id,
            ],
        ]);

        $this->assertDatabaseHas(
            'users',
            [
                'type' => User::TYPE_ADMIN,
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'active' => true,
            ]
        );

        $this->assertDatabaseHas('model_has_roles', [
            'role_id' => Role::whereName(config('template.access.role.admin'))->first()->id,
            'model_type' => User::class,
            'model_id' => User::whereEmail('john@example.com')->first()->id,
        ]);

        $response->assertSessionHas(['flash_success' => __('The user was successfully created.')]);

        Event::assertDispatched(UserCreated::class);
    }

    /** @test */
    public function whenAnUnconfirmedUserIsCreatedANotificationWillBeSent()
    {
        Notification::fake();

        $this->loginAsAdmin();

        $response = $this->post('/admin/auth/user', [
            'type' => User::TYPE_ADMIN,
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'OC4Nzu270N!QBVi%U%qX',
            'password_confirmation' => 'OC4Nzu270N!QBVi%U%qX',
            'send_confirmation_email' => '1',
            'roles' => [
                Role::whereName(config('template.access.role.admin'))->first()->id,
            ],
        ]);

        $response->assertSessionHas(['flash_success' => __('The user was successfully created.')]);

        $user = User::where('email', 'john@example.com')->first();

        Notification::assertSentTo($user, VerifyEmail::class);
    }

    /** @test */
    public function onlyAdminCanCreateUsers()
    {
        $this->actingAs(User::factory()->admin()->create());

        $response = $this->get('/admin/auth/user/create');

        $response->assertSessionHas('flash_danger', __('You do not have access to do that.'));
    }
}
