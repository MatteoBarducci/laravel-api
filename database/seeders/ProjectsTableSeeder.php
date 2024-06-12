<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Models\Project;
use Illuminate\Support\Str;

class ProjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for($i = 0; $i < 10; $i++) {
            $newProject = new Project();
            $newProject->titolo = $faker->sentence(3);
            $newProject->descrizione = $faker->text(500);
            $newProject->slug = Str::slug($newProject->title, '-');
            $newProject->save();
        }
    }
}
