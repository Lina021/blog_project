<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $tagNames = [
            'Algorithms', 'Data Structures', 'Python', 'Laravel',
            'Cybersecurity', 'Database', 'Machine Learning',
            'Operating Systems', 'DevOps', 'Web Development', 'PHP',
            'CSS', 'HTML', 'JavaScript', 'Data Analysis', 'Data Science',
            'Deep Learning', 'Artificial Intelligence',
        ];

        $tags = collect($tagNames)->map(function (string $name): Tag {
            return Tag::firstOrCreate(['name' => $name]);
        });

        Post::factory(15)->for($user)->create()->each(function (Post $post) use ($tags, $user): void {
            Comment::factory(2)->for($post)->for($user)->create();
            $post->tags()->sync($tags->random(2));
        });
    }
}
