<?php

use Faker\Generator as Faker;
use App\HeirachyGroup;

$factory->define(HeirachyGroup::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'description' => $faker->sentence,
        'user_id' => 1,
    ];
});
