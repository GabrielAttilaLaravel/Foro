<?php

use App\Models\Category;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PostListTest extends FeatureTestCase
{
    function test_a_user_can_see_the_posts_list_and_go_to_the_details()
    {
        $post = $this->createPost([
            'title' => '¿Debo usar Laravel 5.3 o 5.1 LTS?'
        ]);

        $this->visit('/')
            ->seeInElement('h1', 'Post')
            ->see($post->title)
            ->click($post->title)
            ->seePageIs($post->url);
    }

    function tests_a_user_can_see_posts_filtered_by_category()
    {
        $laravel = factory(Category::class)->create([
            'name' => 'Laravel',
            'slug' => 'laravel'
        ]);

        $vue = factory(Category::class)->create([
            'name' => 'Vue,js',
            'slug' => 'vue-js'
        ]);

        $laravelPost = factory(Post::class)->create([
            'title' => 'Post de Laravel',
            'category_id' => $laravel->id
        ]);

        $vuePost = factory(Post::class)->create([
            'title' => 'Post de Vue.js',
            'category_id' => $vue->id
        ]);

        $this->visit('/')
            ->see($laravelPost->title)
            ->see($vuePost->title)
            // cuando el usuario haga click en el enlace que se va a llamar laravel
            // el cual estara en el listado de categorias
            ->within('.categories', function (){
                    $this->click('Laravel');
                })
            ->seeInElement('h1', 'Post de Laravel')
            ->see($laravelPost->title)
            ->dontSee($vuePost->title);

    }

    function test_the_posts_are_paginated()
    {
        $first = $this->createPost([
            'title' => 'Post más antiguo',
            'created_at' => Carbon::now()->subDays(2),
        ]);

        factory(Post::class, 15)->create([
            'created_at' => Carbon::now()->subDay(),
        ]);

        $last = $this->createPost([
            'title' => 'Post más reciente',
            'created_at' => Carbon::now(),
        ]);

        $this->visit('/')
            ->see($last->title)
            ->dontSee($first->title)
            ->click('2')
            ->see($first->title)
            ->dontSee($last->title);
    }
}
