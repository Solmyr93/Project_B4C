<?php

use Faker\Generator as Faker;


$factory->define(Laraspace\User::class, function (Faker $faker) {
    return [
        'first_name' => $faker->name,
        'last_name' => $faker->lastName,
        'email' => $faker->email,
        'role' => 'user',
        'password' => bcrypt($faker->word),
        'avatar' => $faker->word,
        'remember_token' => $faker->word
    ];
});
