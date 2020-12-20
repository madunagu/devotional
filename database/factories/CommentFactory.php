<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Comment;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    return [
        'comment' => $faker->sentence,
        'user_id' => 1,
        'commentable_id' => 1,
        'commentable_type' => 'video'
    ];
});
