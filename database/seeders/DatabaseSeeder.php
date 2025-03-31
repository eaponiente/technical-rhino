<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Media;
use App\Models\Tag;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $tags = Tag::factory()->count(10)->create();

        Media::factory(10)->create()->each(function ($media) use ($tags) {
            // Attach 1 to 3 random tags per media
            $media->tags()->attach($tags->random(rand(1, 3))->pluck('id'));
        });
        Author::factory()->count(5)->create();


    }
}
