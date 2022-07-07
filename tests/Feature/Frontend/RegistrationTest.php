<?php

namespace Tests\Feature\Frontend;

use App\Domains\Auth\Models\User;
use App\Domains\Auth\Services\UserService;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

/**
 * Class RegistrationTest.
 */
class RegistrationTest extends TestCase
{
    /** @test */
    public function theRegisterRouteExists()
    {
        $this->get('/register')->assertOk();
    }

    /** @test */
    public function registrationRequiresValidation()
    {
        $response = $this->post('/register');

        $response->assertSessionHasErrors(['name', 'email', 'password', 'terms']);
    }

    /** @test */
    public function emailMustBeUnique()
    {
        User::factory()->create(['email' => 'john@example.com']);

        $response = $this->post('/register', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertSessionHasErrors('email');
    }

    /** @test */
    public function passwordMustBeConfirmed()
    {
        $response = $this->post('/register', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password',
        ]);

        $response->assertSessionHasErrors('password');
    }

    /** @test */
    public function passwordsMustBeEquivalent()
    {
        $response = $this->post('/register', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password',
            'password_confirmation' => 'not_the_same',
        ]);

        $response->assertSessionHasErrors('password');
    }

    /** @test */
    public function userRegistrationCanBeDisabled()
    {
        config(['template.access.user.registration' => false]);

        $this->get('/register')->assertStatus(404);
    }

    /** @test */
    public function aUserCanRegisterAnAccount()
    {
        $this->post('/register', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'OC4Nzu270N!QBVi%U%qX',
            'password_confirmation' => 'OC4Nzu270N!QBVi%U%qX',
            'terms' => '1',
        ])->assertRedirect(route(homeRoute()));

        $user = resolve(UserService::class)
            ->where('email', 'john@example.com')
            ->firstOrFail();

        $this->assertSame($user->name, 'John Doe');
        $this->assertTrue(Hash::check('OC4Nzu270N!QBVi%U%qX', $user->password));
    }

    /** @test */
    public function aUserCantRegisterAnAccountIfTheyDontAcceptTheTerms()
    {
        $response = $this->post('/register', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'OC4Nzu270N!QBVi%U%qX',
            'password_confirmation' => 'OC4Nzu270N!QBVi%U%qX',
        ]);

        $response->assertSessionHasErrors(['terms']);
    }
}
