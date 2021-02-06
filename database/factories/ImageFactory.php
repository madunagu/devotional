<?php

use App\Image;
use App\Universal\Constants;
use Faker\Generator as Faker;

$factory->define(Image::class, function (Faker $faker) {
    return [
        'avatar_url' => $faker->imageUrl(50, 50),
        'small_url' => $faker->imageUrl('100,100'),
        'medium_url' => $faker->imageUrl('200,200'),
        'large_url' => $faker->imageUrl('500,500'),
        'imageable_id' => random_int(1, 10),
        'imageable_type' => Constants::$_[rand(0, 5)],
        'user_id' => 1
    ];
});
