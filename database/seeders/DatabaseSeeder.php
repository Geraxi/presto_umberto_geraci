<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

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
        // User::factory(10)->create();

       foreach ($this->categories as $category){
        Category::create([
            'name'=>$category
        ]);
       }
    }
}
