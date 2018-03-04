<?php

use Faker\Generator as Faker;

function getRandomTag(){
    $tags = [
    	'pyszne', 
    	'wypasione', 
    	'na każdą okazję', 
    	'na żadną okazję', 
    	'kiedy przeżywasz śmiertelny głód', 
    	'kiedy jesteś mega obżarty', 
    	'żarcie do windy', 
    	'żarcie do pociągu', 
    	'żarcie do autobusu'
    ];

    return $tags[rand(0, count($tags)-1)];
}

$factory->define(Laraspace\Tag::class, function (Faker $faker) {
    return [
        'name' => getRandomTag()
    ];
});
