<?php

namespace Database\Factories;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Tag>
 */
class TagFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $tagNames = [
            'Algorithms', 'Data Structures', 'Python', 'Laravel',
            'Cybersecurity', 'Database', 'Machine Learning',
            'Operating Systems', 'DevOps', 'Web Development', 'PHP',
            'CSS', 'HTML', 'JavaScript', 'Data Analysis', 'Data Science',
            'Deep Learning', 'Artificial Intelligence', 'AI',
        ];

        return [
            'name' => fake()->unique()->randomElement($tagNames),
        ];
    }
}
