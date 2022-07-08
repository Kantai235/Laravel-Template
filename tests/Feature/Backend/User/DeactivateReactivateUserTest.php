<?php

namespace Tests\Feature\Backend\User;

use App\Domains\Auth\Events\User\UserStatusChanged;
use App\Domains\Auth\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

/**
 * Class DeactivateReactivateUserTest.
 */
class DeactivateReactivateUserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function onlyAUserWithCorrectPermissionsCanVisitDeactivatedUsers()
    {
        $this->actingAs($user = User::factory()->admin()->create());

        $user->syncPermissions(['admin.access.user.reactivate']);

        $this->get('/admin/auth/user/deactivated')->assertOk();

        $user->syncPermissions([]);

        $response = $this->get('/admin/auth/user/deactivated');

        $response->assertSessionHas('flash_danger', __('You do not have access to do that.'));
    }

    /** @test */
    public function aUserWithTheCorrectPermissionsCanReactivateAUser()
    {
        Event::fake();

        $this->actingAs($user = User::factory()->admin()->create());

        $user->syncPermissions(['admin.access.user.reactivate']);

        $deactivatedUser = User::factory()->inactive()->create();

        $this->assertDatabaseHas('users', [
            'id' => $deactivatedUser->id,
            'active' => false,
        ]);

        $this->patch('/admin/auth/user/' . $deactivatedUser->id . '/mark/1');

        $this->assertDatabaseHas('users', [
            'id' => $deactivatedUser->id,
            'active' => true,
        ]);

        Event::assertDispatched(UserStatusChanged::class);
    }

    /** @test */
    public function aUserWithoutTheCorrectPermissionsCanNotReactivateAUser()
    {
        $this->actingAs(User::factory()->admin()->create());

        $deactivatedUser = User::factory()->inactive()->create();

        $this->assertDatabaseHas('users', [
            'id' => $deactivatedUser->id,
            'active' => false,
        ]);

        $response = $this->patch('/admin/auth/user/' . $deactivatedUser->id . '/mark/1');

        $response->assertSessionHas('flash_danger', __('You do not have access to do that.'));

        $this->assertDatabaseHas('users', [
            'id' => $deactivatedUser->id,
            'active' => false,
        ]);
    }

    /** @test */
    public function aUserWithTheCorrectPermissionsCanDeactivateAUser()
    {
        Event::fake();

        $this->actingAs($user = User::factory()->admin()->create());

        $user->syncPermissions(['admin.access.user.deactivate']);

        $activeUser = User::factory()->active()->create();

        $this->assertDatabaseHas('users', [
            'id' => $activeUser->id,
            'active' => true,
        ]);

        $this->patch('/admin/auth/user/' . $activeUser->id . '/mark/0');

        $this->assertDatabaseHas('users', [
            'id' => $activeUser->id,
            'active' => false,
        ]);

        Event::assertDispatched(UserStatusChanged::class);
    }

    /** @test */
    public function aUserWithoutTheCorrectPermissionsCanNotDeactivateAUser()
    {
        $this->actingAs(User::factory()->admin()->create());

        $activeUser = User::factory()->active()->create();

        $this->assertDatabaseHas('users', [
            'id' => $activeUser->id,
            'active' => true,
        ]);

        $response = $this->patch('/admin/auth/user/' . $activeUser->id . '/mark/0');

        $response->assertSessionHas('flash_danger', __('You do not have access to do that.'));

        $this->assertDatabaseHas('users', [
            'id' => $activeUser->id,
            'active' => true,
        ]);
    }

    /** @test */
    public function aUserCanNotDeactivateThemselves()
    {
        $this->actingAs($user = User::factory()->admin()->create());

        $user->syncPermissions(['admin.access.user.deactivate']);

        $response = $this->patch('/admin/auth/user/' . $user->id . '/mark/0');

        $response->assertSessionHas('flash_danger', __('You can not do that to yourself.'));
    }

    /** @test */
    public function aUserCanNotDeactivateTheMasterAdmin()
    {
        $this->actingAs($user = User::factory()->admin()->create());

        $user->syncPermissions(['admin.access.user.deactivate']);

        $response = $this->patch('/admin/auth/user/' . $this->getMasterAdmin()->id . '/mark/0');

        $response->assertSessionHas('flash_danger', __('You can not deactivate the administrator account.'));
    }
}
