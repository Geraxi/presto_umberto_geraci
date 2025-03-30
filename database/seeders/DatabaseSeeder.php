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
                'title' => 'Articolo di Elettronica',
                'body' => 'Questo è un articolo di esempio per la categoria elettronica. Contiene del contenuto dimostrativo per mostrare come gli articoli appaiono sul sito.',
                'price' => 299.99,
                'user_id' => $admin->id,
                'category_id' => $category->id,
                'is_accepted' => true,
            ]);
        }
    }
}
