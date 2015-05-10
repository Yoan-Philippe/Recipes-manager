<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'HomeController@index');

//Route concernant les ingrédients
Route::get('/ingredients', 'IngredientsController@index');
Route::get('ingredients/delete/{id}', 'IngredientsController@delete');
Route::get('ingredients/add', 'IngredientsController@add');
Route::post('ingredients/add', 'IngredientsController@add');

//Route concernant les recettes
Route::get('/recipes', 'RecipesController@index');
Route::get('recipes/delete/{id}', 'RecipesController@delete');
Route::get('recipes/add', 'RecipesController@add');
Route::post('recipes/add', 'RecipesController@add');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);