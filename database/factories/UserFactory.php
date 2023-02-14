<?php

namespace Database\Factories;

use App\Domains\Auth\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'type' => $this->faker->randomElement([
                User::TYPE_ADMIN,
                User::TYPE_USER,
            ]),
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => 'secret',
            'password_changed_at' => null,
            'remember_token' => Str::random(10),
            'active' => true,
        ];
    }

    public function admin(): UserFactory
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => User::TYPE_ADMIN,
            ];
        });
    }

    public function user(): UserFactory
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => User::TYPE_USER,
            ];
        });
    }

    public function active(): UserFactory
    {
        return $this->state(function (array $attributes) {
            return [
                'active' => true,
            ];
        });
    }

    public function inactive(): UserFactory
    {
        return $this->state(function (array $attributes) {
            return [
                'active' => false,
            ];
        });
    }

    public function confirmed(): UserFactory
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => now(),
            ];
        });
    }

    public function unconfirmed(): UserFactory
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }

    public function passwordExpired(): UserFactory
    {
        return $this->state(function (array $attributes) {
            return [
                'password_changed_at' => now()->subYears(5),
            ];
        });
    }

    public function deleted(): UserFactory
    {
        return $this->state(function (array $attributes) {
            return [
                'deleted_at' => now(),
            ];
        });
    }
}
