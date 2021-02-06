<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Devotional;
use Faker\Generator as Faker;


$factory->define(Devotional::class, function (Faker $faker) {
    $posterTypes = ['user', 'church', 'society',];

    return [
        'title' => $faker->sentence,
        'opening_prayer' => $faker->paragraph,
        'closing_prayer' => $faker->paragraph,
        'body' => $faker->text,
        'memory_verse' => 'John 3:16',
        'day' => $faker->dateTime,
        'poster_id' => rand(1,10),
        'poster_type' => $posterTypes[rand(0,2)]
    ];
});
