<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake()->word,
            'description' => fake()->paragraph
        ];
    }
}
