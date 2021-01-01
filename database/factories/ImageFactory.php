<?php

use App\Image;
use Faker\Generator as Faker;

$factory->define(Image::class, function (Faker $faker) {
    $types = ['audio', 'video', 'post'];

    return [
        'avatar_url' => $faker->imageUrl(50, 50),
        'small_url' => $faker->imageUrl('100,100'),
        'medium_url' => $faker->imageUrl('200,200'),
        'large_url' => $faker->imageUrl('500,500'),
        'imageable_id' => random_int(1, 10),
        'imageable_type' => $types[rand(0, count($types))],
        'user_id' => 1
    ];
});
