<?php

namespace Database\Factories;

use App\Domains\Auth\Models\Role;
use App\Domains\Auth\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Role::class;

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
            'name' => $this->faker->word,
        ];
    }
}
