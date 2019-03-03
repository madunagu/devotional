<?php

use Faker\Generator as Faker;
use App\Event;

$factory->define(Event::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'church_id' => 1,
        'starting_at' => $faker->dateTime,
        'ending_at' => $faker->dateTime,
        'address_id' => 1,
        'heirachy_group_id'=>1,
        'profile_media_id'=>1,
        'user_id'=>1,
    ];
});
