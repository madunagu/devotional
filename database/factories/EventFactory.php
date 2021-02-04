<?php

use Faker\Generator as Faker;
use App\Event;

$factory->define(Event::class, function (Faker $faker) {
    $posters = ['user', 'church', 'society'];
    return [
        'name' => $faker->sentence(5),
        'starting_at' => $faker->dateTime()->format('Y-m-d H:i:s'),
        'ending_at' => $faker->dateTime()->format('Y-m-d H:i:s'),
        'user_id' => rand(1, 10),
        'poster_type' => $posters[rand(0, 2)],
        'poster_id' => rand(1, 10),
    ];
});
