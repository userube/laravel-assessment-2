<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tag;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $tags = ['Technology', 'Science', 'Health', 'Entertainment', 'Sports', 'Politics'];
        
        foreach ($tags as $tag) {
            Tag::create(['name' => $tag]);
        }
    }
}