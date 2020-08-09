<?php

use Faker\Generator as Faker;
use App\HierarchyGroup;

$factory->define(HierarchyGroup::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'description' => $faker->sentence,
        'user_id' => 1,
    ];
});
