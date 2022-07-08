<?php

namespace Tests\Feature\Backend\User;

use App\Domains\Auth\Events\User\UserDeleted;
use App\Domains\Auth\Events\User\UserDestroyed;
use App\Domains\Auth\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

/**
 * Class DeleteUserTest.
 */
class DeleteUserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function anAdminCanAccessDeletedUsersPage()
    {
        $this->loginAsAdmin();

        $response = $this->get('/admin/auth/user/deleted');

        $response->assertOk();

        $this->logout();

        $this->actingAs(User::factory()->create());

        $response = $this->get('/admin/auth/user/deleted');

        $response->assertSessionHas('flash_danger', __('You do not have access to do that.'));
    }

    /** @test */
    public function aUserCanBeDeleted()
    {
        Event::fake();

        $this->loginAsAdmin();

        $user = User::factory()->create();

        $response = $this->delete("/admin/auth/user/{$user->id}");

        $response->assertSessionHas(['flash_success' => __('The user was successfully deleted.')]);

        $this->assertSoftDeleted('users', ['id' => $user->id]);

        Event::assertDispatched(UserDeleted::class);
    }

    /** @test */
    public function aUserCanBePermanentlyDeleted()
    {
        Event::fake();

        config(['template.access.user.permanently_delete' => true]);

        $this->loginAsAdmin();

        $user = User::factory()->deleted()->create();

        $this->assertSoftDeleted('users', ['id' => $user->id]);

        $response = $this->delete("/admin/auth/user/{$user->id}/permanently-delete");

        $response->assertSessionHas(['flash_success' => __('The user was permanently deleted.')]);

        $this->assertDatabaseMissing('users', ['id' => $user->id]);

        Event::assertDispatched(UserDestroyed::class);
    }

    /** @test */
    public function aUserCantBePermanentlyDeletedIfTheOptionIsOff()
    {
        config(['template.access.user.permanently_delete' => false]);

        $this->loginAsAdmin();

        $user = User::factory()->deleted()->create();

        $this->assertSoftDeleted('users', ['id' => $user->id]);

        $this->delete("/admin/auth/user/{$user->id}/permanently-delete")->assertNotFound();

        $this->assertSoftDeleted('users', ['id' => $user->id]);
    }

    /** @test */
    public function aUserCanBeRestored()
    {
        $this->loginAsAdmin();

        $user = User::factory()->deleted()->create();

        $this->assertSoftDeleted('users', ['id' => $user->id]);

        $response = $this->patch("/admin/auth/user/{$user->id}/restore");

        $response->assertSessionHas(['flash_success' => __('The user was successfully restored.')]);

        $this->assertDatabaseHas('users', ['id' => $user->id]);
    }

    /** @test */
    public function theMasterAdministratorCanNotBeDeleted()
    {
        $admin = $this->getMasterAdmin();
        $user = User::factory()->admin()->create();
        $user->assignRole($this->getAdminRole());
        $this->actingAs($user);

        $response = $this->delete('/admin/auth/user/' . $admin->id);

        $response->assertSessionHas('flash_danger', __('You can not delete the master administrator.'));

        $this->assertDatabaseHas('users', ['id' => $admin->id, 'deleted_at' => null]);
    }

    /** @test */
    public function aUserCanNotDeleteThemselves()
    {
        $user = User::factory()->admin()->create();
        $user->assignRole($this->getAdminRole());
        $this->actingAs($user);

        $response = $this->delete('/admin/auth/user/' . $user->id);

        $response->assertSessionHas('flash_danger', __('You can not delete yourself.'));

        $this->assertDatabaseHas('users', ['id' => $user->id, 'deleted_at' => null]);
    }

    /** @test */
    public function onlyAdminCanDeleteUsers()
    {
        $this->actingAs(User::factory()->create());

        $user = User::factory()->create();

        $response = $this->delete("/admin/auth/user/{$user->id}");

        $response->assertSessionHas('flash_danger', __('You do not have access to do that.'));
    }
}
