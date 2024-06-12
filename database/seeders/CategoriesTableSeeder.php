<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = ['FrontEnd', 'Backend', 'FullStack', 'Design', 'DevOps'];

        // per ogni categoria crea nuova istanza di Category, la popolo e la salvo
        foreach ($categories as $categoryName) {
            $newCategory = new Category();
            $newCategory->name = $categoryName;
            $newCategory->slug = Str::slug($newCategory->name, '-');
            $newCategory->save();
        }
    }
}
