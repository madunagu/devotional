<?php

use Faker\Generator as Faker;

use App\Society;

$factory->define(Society::class, function (Faker $faker) {
    return [
        'name'=>$faker->name,
        'parent_id'=>0,
        'closed'=>1,
        'description'=>$faker->sentence,
        'user_id'=>1
    ];
});
