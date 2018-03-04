<?php

/*
|--------------------------------------------------------------------------
| Frontend Routes
|--------------------------------------------------------------------------
|
*/

Route::get('/laracpace', function () {
    return view('app');
})->where('vue', '[\/\w\.-]*')->name('home');

Route::get('/{vue?}', function () {
    return view('book4cook');
})->where('vue', '[\/\w\.-]*')->name('home');
