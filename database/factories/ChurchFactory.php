<?php

use Faker\Generator as Faker;
use App\Church;

$factory->define(Church::class, function (Faker $faker) {
    return [
        'id' => $faker->uuid,
        'name' => $faker->name,
        'slug' => $faker->slug,
        'featured_img' => $faker->imageUrl(640, 480),
        'avatar' => $faker->imageUrl(48, 48),
        'description' => $faker->paragraph,
        'latitude' => $faker->latitude(-90, 90),
        'longitude' => $faker->longitude(-180, 180),
        'address' => $faker->streetAddress,
        'city' => $faker->city,
        'state' => $faker->state,
        'postal_code' => $faker->postcode,
        'country' => $faker->country,
        'rating' => $faker->numberBetween(0, 5),
        'featured' => $faker->numberBetween(0, 1),
        'verified' => $faker->numberBetween(0, 1)
    ];
});

$factory->state(YourAppName\YourModelName::class, 'product', [
    'category' => 'Product',
]);
