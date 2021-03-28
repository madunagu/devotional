<?php

use Faker\Generator as Faker;
use App\Hierarchy;

$factory->define(Hierarchy::class, function (Faker $faker) {
    return [
        'rank' => $faker->numberBetween(0,7),
        'position_name' => $faker->name,
        'position_slang' => $faker->name,
        'person_name' => $faker->name,
        'user_id'=>$faker->numberBetween(0,20),
    ];
});
