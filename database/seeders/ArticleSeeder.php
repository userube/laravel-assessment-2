<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Article;
use Faker\Factory as Faker;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < 20; $i++) {
            Article::create([
                'title' => $faker->sentence,
                'body' => $faker->paragraph,
                'author' => $faker->name,
                'published_at' => $faker->dateTimeThisYear(),
            ]);
        }
    }
}