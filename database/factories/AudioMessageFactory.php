<?php

use Faker\Generator as Faker;

use App\AudioMessage;
use Illuminate\Support\Facades\Storage;

$factory->define(AudioMessage::class, function (Faker $faker) {
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
