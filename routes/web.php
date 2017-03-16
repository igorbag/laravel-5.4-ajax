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

Route::get('/', function () {
    return view('welcome');
});




Auth::routes();

	Route::get('/home', 'CRUDController@index');
	//Rotas da aplicacao WEB do CRUD
  	Route::get('crud', 'CRUDController@index');
    Route::post('crud', 'CRUDController@add');
    Route::get('crud/view', 'CRUDController@view');
    Route::post('crud/update', 'CRUDController@update');
    Route::post('crud/delete', 'CRUDController@delete');