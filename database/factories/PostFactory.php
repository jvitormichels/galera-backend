<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(), // Default: creates new user
            'text' => $this->faker->paragraph(),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }

    /**
     * Attach post to existing user
     */
    public function forUser(User|int $user): static
    {
        return $this->state(function (array $attributes) use ($user) {
            return [
                'user_id' => is_int($user) ? $user : $user->id,
            ];
        });
    }

    /**
     * Create post with specific text
     */
    public function withText(string $text): static
    {
        return $this->state(['text' => $text]);
    }
}