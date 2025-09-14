<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Clear existing data
        DB::table('category_post')->delete();
        DB::table('posts')->delete();
        DB::table('categories')->delete();
        DB::table('users')->delete();

        // Create admin user
        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);
        
        // Create additional users
        User::factory(5)->create();
        
        // Create categories
        $categories = Category::factory(10)->create();
        
        // Create posts and attach categories
        Post::factory(50)->create()->each(function ($post) use ($categories) {
            // Attach 1-3 random categories to each post
            $post->categories()->attach(
                $categories->random(rand(1, 3))->pluck('id')->toArray()
            );
        });
    }
}