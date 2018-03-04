<?php

use Faker\Generator as Faker;

function getRandomCategory() {
    $categories = [
    	'desery', 
    	'słodycze', 
    	'słonicze', 
    	'kwiasicze', 
    	'obiad', 
    	'pierwsze danie', 
    	'drugie danie', 
    	'trzecie danie', 
    	'zupy', 
    	'kartofle'
    ];

    return $categories[rand(0, count($categories)-1)];
}

$factory->define(Laraspace\Category::class, function (Faker $faker) {
    return [
        'name' => getRandomCategory(),
        'parent_category_id' => rand(0, 10)
    ];
});
