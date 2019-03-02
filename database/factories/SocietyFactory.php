<?php

use Faker\Generator as Faker;

use App\Society;

$factory->define(Society::class, function (Faker $faker) {
    return [
        'name'=>$faker->name,
        'church_id'=>1,
        'parent_id'=>0,
        'closed'=>1,
        'profile_media_id'=>1,
        'heirachy_group_id'=>1,
        'description'=>$faker->sentence
    ];
});
