<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Akses>
 */
class AksesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "ACCESS_ID" => uuid_create(4),
            "ACCESS_NAME" => fake()->word(),
            "ACCESS_CREATE" => random_int(0, 1),
            "ACCESS_READ" => random_int(0, 1),
            "ACCESS_UPDATE" => random_int(0, 1),
            "ACCESS_DELETE" => random_int(0, 1),
            "ACCESS_RESTORE" => random_int(0, 1),
            "ACCESS_DESTROY" => random_int(0, 1),
            "ACCESS_DETAIL" => random_int(0, 1),
            "ACCESS_VIEW" => random_int(0, 1),
        ];
    }
}
