<?php

use Faker\Generator as Faker;
use App\Event;

$factory->define(Event::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence(5),
        'church_id' => 1,
        'starting_at' => $faker->dateTime()->format('Y-m-d H:i:s'),
        'ending_at' => $faker->dateTime()->format('Y-m-d H:i:s'),
        'address_id' => rand(1,10),
        'hierarchy_group_id'=>1,
        'profile_media_id'=>1,
        'user_id'=>rand(1,10),
    ];
});
