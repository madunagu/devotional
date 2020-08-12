<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\Post::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence,
        'church_id' => rand(1,10),
        'profile_media_id' =>  rand(1,10),
        'user_id' => rand(1,10),
        'body' => $faker->paragraphs(6, true),
    ];
});
