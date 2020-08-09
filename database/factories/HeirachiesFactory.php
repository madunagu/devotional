<?php

use Faker\Generator as Faker;
use App\Hierarchy;

$factory->define(Hierarchy::class, function (Faker $faker) {
    return [
        'hierarchy_group_id'=>1,
        'rank' => $faker->numberBetween(0,7),
        'position_name' => $faker->name,
        'position_slang' => $faker->name,
        'person_name' => $faker->name,
        'user_id'=>1,
    ];
});
