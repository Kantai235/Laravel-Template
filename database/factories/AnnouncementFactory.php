<?php

namespace Database\Factories;

use App\Domains\Announcement\Models\Announcement;
use Illuminate\Database\Eloquent\Factories\Factory;

class AnnouncementFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Announcement::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'area' => $this->faker->randomElement([
                Announcement::AREA_FRONTEND,
                Announcement::AREA_BACKEND,
            ]),
            'type' => $this->faker->randomElement([
                Announcement::TYPE_PRIMARY,
                Announcement::TYPE_SECONDARY,
                Announcement::TYPE_SUCCESS,
                Announcement::TYPE_DANGER,
                Announcement::TYPE_WARNING,
                Announcement::TYPE_INFO,
                Announcement::TYPE_LIGHT,
                Announcement::TYPE_DARK,
            ]),
            'message' => $this->faker->text,
            'enabled' => $this->faker->boolean,
            'starts_at' => $this->faker->dateTime(),
            'ends_at' => $this->faker->dateTime(),
        ];
    }

    public function enabled(): AnnouncementFactory
    {
        return $this->state(function (array $attributes) {
            return [
                'enabled' => true,
            ];
        });
    }

    public function disabled(): AnnouncementFactory
    {
        return $this->state(function (array $attributes) {
            return [
                'enabled' => false,
            ];
        });
    }

    public function frontend(): AnnouncementFactory
    {
        return $this->state(function (array $attributes) {
            return [
                'area' => Announcement::AREA_FRONTEND,
            ];
        });
    }

    public function backend(): AnnouncementFactory
    {
        return $this->state(function (array $attributes) {
            return [
                'area' => Announcement::AREA_BACKEND,
            ];
        });
    }

    public function global(): AnnouncementFactory
    {
        return $this->state(function (array $attributes) {
            return [
                'area' => null,
            ];
        });
    }

    public function noDates(): AnnouncementFactory
    {
        return $this->state(function (array $attributes) {
            return [
                'starts_at' => null,
                'ends_at' => null,
            ];
        });
    }

    public function insideDateRange(): AnnouncementFactory
    {
        return $this->state(function (array $attributes) {
            return [
                'starts_at' => now()->subWeek(),
                'ends_at' => now()->addWeek(),
            ];
        });
    }

    public function outsideDateRange(): AnnouncementFactory
    {
        return $this->state(function (array $attributes) {
            return [
                'starts_at' => now()->subWeeks(2),
                'ends_at' => now()->subWeek(),
            ];
        });
    }
}
