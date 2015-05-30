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
Route::get('ingredients/edit/{id}', 'IngredientsController@showEdit');
Route::post('ingredients/edit', 'IngredientsController@edit');
Route::get('ingredients/add', 'IngredientsController@add');
Route::post('ingredients/add', 'IngredientsController@add');

Route::get('ingredients/editQuantity/{value}', 'IngredientsController@editQuantity');
Route::post('ingredients/editQuantity/{value}', 'IngredientsController@editQuantity');

Route::get('ingredients/saveQuantity/{value}/{id}', 'IngredientsController@saveQuantity');
Route::post('ingredients/saveQuantity/{value}/{id}', 'IngredientsController@saveQuantity');

//Route concernant les recettes
Route::get('/recipes', 'RecipesController@index');
Route::get('recipes/delete/{id}', 'RecipesController@delete');
Route::get('recipes/{id}', 'RecipesController@view');
Route::get('recipes/edit/{id}', 'RecipesController@showEdit');
Route::post('recipes/edit', 'RecipesController@edit');
Route::get('recipes/add', 'RecipesController@add');
Route::post('recipes/add', 'RecipesController@add');


Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
