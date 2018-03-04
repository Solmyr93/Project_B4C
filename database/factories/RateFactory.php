<?php

use Faker\Generator as Faker;

$factory->define(Laraspace\Rate::class, function (Faker $faker) {
    return [
        'value' => rand(0,5),
        'user_id' => rand(1,10), 
        'recipe_id' => rand(1,10),
    ];
});
