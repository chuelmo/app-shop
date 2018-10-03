<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'TestController@welcome');

Route::get('/prueba', function () {
    return 'Hola, soy la ruta prueba';
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/products/{id}', 'ProductController@show');
Route::post('/cart', 'CartDetailController@store');
Route::delete('/cart', 'CartDetailController@destroy');

Route::post('/order', 'CartController@update');

Route::middleware(['auth', 'admin'])->prefix('admin')->namespace('Admin')->group(function() {
	Route::get('/products', 'ProductController@index');// listar productos
	Route::get('/products/create', 'ProductController@create'); //crear productos
	Route::post('/products', 'ProductController@store'); //guardar el producto en la DB
	Route::get('/products/{id}/edit', 'ProductController@edit'); //formulario de edición
	Route::post('/products/{id}/edit', 'ProductController@update'); //actualizar
	Route::delete('/products/{id}', 'ProductController@destroy'); //Manera correcta de borrar

	Route::get('/products/{id}/images', 'ImageController@index');
	Route::post('/products/{id}/images', 'ImageController@store');
	Route::delete('/products/{id}/images', 'ImageController@destroy');
	Route::get('/products/{id}/images/featuredimage/{image}', 'ImageController@featuredimage');
	//Route::get('/admin/products/{id}/delete', 'ProductController@destroy'); //ASI SE BORRA DE MANERA INSEGURA CON GET
	//Route::post('/admin/products/{id}/delete', 'ProductController@destroy'); //Manera correcta de borrar
});



// El post tiene 'alias': PUT PATCH DELETE
