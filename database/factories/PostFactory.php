<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\Post::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence,
        'user_id' => rand(1,10),
        'body' => $faker->paragraph,
    ];
});
