<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $comments = [
            'The explanation of the time complexity makes the tradeoff much clearer. I would also mention how the choice changes when the data is not sorted.',
            'This is a useful connection between the theory and the code we write every day. The example makes the main idea easy to follow.',
            'The section about performance is especially helpful. It shows why a simple solution is not always the best solution at scale.',
            'I like the focus on practical behavior rather than memorizing definitions. This would be a good topic for a small experiment.',
            'The distinction between correctness and efficiency is important here. A solution can produce the right result and still be too expensive.',
            'This topic becomes much easier once the underlying data structure is visualized. The relationship between the operations is a good takeaway.',
        ];

        return [
            'post_id' => Post::factory(),
            'user_id' => User::factory(),
            'comment' => fake()->randomElement($comments),
        ];
    }
}
