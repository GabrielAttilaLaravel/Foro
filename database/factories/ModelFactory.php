<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {

    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'username' => $faker->unique()->userName,
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Models\Post::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'title' => $faker->sentence,
        'content' => $faker->paragraph,
        'pending' => true,
        'user_id' => function (){
                return factory(\App\User::class)->create()->id;
            },
        'category_id' => function (){
                return factory(\App\Models\Category::class)->create()->id;
            },
    ];
});

$factory->define(App\Models\Comment::class, function (Faker\Generator $faker) {
    return [
        'comment' => $faker->paragraph,
        'user_id' => function (){
            return factory(\App\User::class)->create()->id;
        },
        'post_id' => function (){
            return factory(\App\Models\Post::class)->create()->id;
        },
    ];
});

$factory->define(App\Models\Category::class, function (Faker\Generator $faker) {
    $name = $faker->unique()->sentence;

    return [
        'name' => $name,
        'slug' => str_slug($name),
    ];
});