<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Article;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
   
     public $categories=[
        'elettronica',
        'abbigliamento',
        'salute e bellezza',
        'casa e giardinaggio',
        'giocattoli',
        'sport',
        'animali domestici',
        'libri e riviste',
        'accesori',
        'motori'
     ];
   
   
     public function run(): void
    {
        // Create admin user
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'is_revisor' => true,
        ]);

        // Create categories
        foreach ($this->categories as $category) {
            Category::create([
                'name' => $category
            ]);
        }

        // Create some sample articles
        $categories = Category::all();
        foreach ($categories as $category) {
            Article::create([
                'title' => "Sample {$category->name} Article",
                'body' => "This is a sample article for the {$category->name} category. It contains some example content to demonstrate how articles appear on the site.",
                'price' => rand(10, 1000),
                'user_id' => $admin->id,
                'category_id' => $category->id,
                'is_accepted' => true,
            ]);
        }
    }
}
