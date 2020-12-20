<?php

use Faker\Generator as Faker;
use App\ProfileMedia;

$factory->define(ProfileMedia::class, function (Faker $faker) {
    return [
        'logo_url'=> $faker->imageUrl(50, 50),
        'profile_image_url'=> $faker->imageUrl('500,500'),
        'background_image_url'=> $faker->imageUrl('500,500'),
        'color_choice'=> $faker->colorName,
        'profile_mediable_id'=> random_int(1,10),
        'profile_mediable_type'=>'video',
        'user_id'=>1
    ];
});
