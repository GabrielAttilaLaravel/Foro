<?php

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Category::class)->create([
            'name' => 'Laravel',
            'slug' => 'laravel',
        ]);

        factory(Category::class)->create([
            'name' => 'PHP',
            'slug' => 'php',
        ]);

        factory(Category::class)->create([
            'name' => 'Vue.js',
            'slug' => 'vue-js',
        ]);
        factory(Category::class)->create([
            'name' => 'JavaScript',
            'slug' => 'javascript',
        ]);
        factory(Category::class)->create([
            'name' => 'CSS',
            'slug' => 'css',
        ]);
        factory(Category::class)->create([
            'name' => 'Sass',
            'slug' => 'sass',
        ]);
        factory(Category::class)->create([
            'name' => 'Git',
            'slug' => 'git',
        ]);
        factory(Category::class)->create([
            'name' => 'Otras tecnologías',
            'slug' => 'otras-tecnologías',
        ]);
    }
}
