<?php

use App\Image;
use App\Universal\Constants;
use Faker\Generator as Faker;

$factory->define(Image::class, function (Faker $faker) {
    return [
        'small' => 'https://picsum.photos/100',
        'medium' => 'https://picsum.photos/200',
        'large' => 'https://picsum.photos/500',
        'full' => 'https://picsum.photos/500',
        'user_id' => 1
    ];
});
