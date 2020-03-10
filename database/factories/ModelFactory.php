<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use App\Post;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->email,
        'password' => password_hash('12345678', PASSWORD_BCRYPT)
    ];
});

$factory->define(Post::class, function (Faker $faker) {
    $title = $faker->sentence();
    return [
        'user_id' => $faker->numberBetween(1, 20),
        'slug' => Str::slug($title),
        'title' => $title,
        'body' => $faker->text()
    ];
});
