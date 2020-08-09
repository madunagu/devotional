<?php

use Faker\Generator as Faker;

use App\AudioPost;
use Illuminate\Support\Facades\Storage;

$factory->define(AudioPost::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'src_url' => Storage::url('audio/Hillsong-Touch-Of-Heaven.mp3'),
        'full_text' => $faker->paragraph,
        'description' => $faker->sentence,
        'author_id' => 1,
        'uploader_id' => 1,
        'church_id' => 1,
        'size' => $faker->numberBetween(0,200000),
        'length' => $faker->numberBetween(0,200000),
        'profile_media_id'=>1,
        'language'=>$faker->languageCode,
        'address_id' => 1,
    ];
});
