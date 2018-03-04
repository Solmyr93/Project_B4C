<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::group(['prefix' => 'auth', 'middleware' => 'api'], function() {
	Route::post('register','AuthController@register');
    Route::post('login','AuthController@authenticate');
    Route::get('logout','AuthController@logout');
    Route::group(['middleware' => 'jwt.auth'], function () {
    	Route::get('check','AuthController@check');
    });
});

Route::group(['prefix' => 'v1'], function () {
	Route::resource('recipes', 'RecipeController');
	Route::get('home','HomeController@index');

	Route::post('store-category','ResourcesController@storeCategory');
	Route::post('store-tag','ResourcesController@storeTag');
	Route::post('store-comment', 'InteractionsController@storeComment');
	Route::post('store-rate', 'InteractionsController@storeRate');
	Route::post('favorite-recipe', 'InteractionsController@addToFavorities');

	Route::patch('update-category/{id}','ResourcesController@updateCategory');
	Route::patch('update-tag/{id}','ResourcesController@updateTag');

	Route::delete('delete-category/{id}','ResourcesController@deleteCategory');
	Route::delete('delete-tag/{id}','ResourcesController@deleteTag');
});