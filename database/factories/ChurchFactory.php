<?php

use Faker\Generator as Faker;
use App\Church;

$factory->define(Church::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'alternate_name' => $faker->name,
        'user_id' => 1,
        'address_id' => 1,
        'description' => $faker->paragraph,
        'slogan' => $faker->sentence,
    ];
});

// $factory->state(YourAppName\YourModelName::class, 'product', [
//     'category' => 'Product',
// ]);
