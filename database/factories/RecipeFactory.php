<?php

use Faker\Generator as Faker;

function getRandomMeal(){
    $meals = [
    	'zupa pomidorowa', 
    	'zupa ogórkowa', 
    	'krupnik', 
    	'czernina', 
    	'kotlet mielony z wieprzem', 
    	'wieprz w ciasteczkach', 
    	'dzieła szekspira w czekoladzie', 
    	'kakao z grzybami'
    ];

    return $meals[rand(0, count($meals)-1)];
}


$factory->define(Laraspace\Recipe::class, function (Faker $faker) {
    return [
    
    'name' => getRandomMeal(),
    'description' => $faker->paragraph(rand(1,5), true),
    'user_id' => rand(1, 10),
    'subcategory_id' => rand(1, 10),
    'ingredients' => $faker->words(rand(4, 10), true)
    
    ];
});
