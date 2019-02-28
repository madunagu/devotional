<?php

use Faker\Generator as Faker;
use App\Address;

$factory->define(Address::class, function (Faker $faker) {
  return [
      'id' => $faker->uuid,
      'address1' => $faker->streetAddress,
      'address1' => $faker->streetAddress,
      'country' => $faker->country,
      'state' => $faker->state,
      'city' => $faker->city,
      'postal_code' => $faker->postcode,
      'name' => $faker->name,
      'latitude' => $faker->latitude(-90, 90),
      'longitude' => $faker->longitude(-180, 180),
  ];
});

// $factory->state(Address::class, 'product', [
//     'category' => 'Product',
// ]);
