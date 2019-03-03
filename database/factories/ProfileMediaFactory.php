<?php

use Faker\Generator as Faker;

$factory->define(Model::class, function (Faker $faker) {
    return [
        'logo_url'=> $faker->imageUrl(50, 50),
        'profile_image_url'=> $faker->imageUrl('500,500'),
        'background_image_url'=> $faker->imageUrl('500,500'),
        'color_choice'=> $faker->colorName,
        'user_id'=>1
    ];
});
