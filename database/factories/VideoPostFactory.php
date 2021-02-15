<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Storage;


$factory->define(\App\VideoPost::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence,
        'src_url' => Storage::url('video/videoplayback.mp4'),
        'full_text' => $faker->paragraph,
        'description' => $faker->sentence,
        'author_id' => 1,
        'uploader_id' => rand(1,20),
        'size' => $faker->numberBetween(0, 200000),
        'length' => $faker->numberBetween(0, 200000),
        'language' => $faker->languageCode,
    ];
});
