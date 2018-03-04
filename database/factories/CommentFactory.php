<?php

use Faker\Generator as Faker;

$factory->define(Laraspace\Comment::class, function (Faker $faker) {
    return [
        'text' => $faker->paragraph(rand(1, 5), true),
        'recipe_id' => rand(1, 10),
        'user_id' => rand(1, 10),
    ];
});
