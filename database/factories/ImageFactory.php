<?php

use App\Image;
use App\Universal\Constants;
use Faker\Generator as Faker;

$factory->define(Image::class, function (Faker $faker) {
    return [
        'avatar_url' => 'https://picsum.photos/50',
        'small_url' => 'https://picsum.photos/100',
        'medium_url' => 'https://picsum.photos/200',
        'large_url' => 'https://picsum.photos/500',
        'user_id' => 1
    ];
});
