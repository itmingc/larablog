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

// 前台路由
Route::group(['namespace' => 'Index'], function () {
	Route::get('/', 'IndexController@index');
	Route::get('cate/{id}', 'CategoryController@index');
	Route::get('a/{id}', 'ArticleController@index');
	Route::get('tag/{id}', 'CommonController@tag');
	Route::get('q', 'CommonController@search');
});


// 后台路由
Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => 'adminLogin'], function () {
	Route::get('index', 'IndexController@index');
	Route::get('info', 'IndexController@info');
	Route::any('password', 'IndexController@password');
	Route::get('logout', 'IndexController@logout');

    Route::post('category/changeSort', 'CategoryController@changeSort');
	Route::resource('category', 'CategoryController');

    Route::resource('article', 'ArticleController');

    Route::post('links/changesort', 'LinksController@changeSort');
    Route::resource('links', 'LinksController');

    Route::post('navs/changesort', 'NavsController@changeSort');
    Route::resource('navs', 'NavsController');

    Route::get('config/writeconfig', 'ConfigController@writeConfig');
    Route::post('config/changecontent', 'ConfigController@changeContent');
    Route::post('config/changesort', 'ConfigController@changeSort');
    Route::resource('config', 'ConfigController');

	Route::post('upload', 'CommonController@upload');
});

// 后台登录路由
Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function (){
	Route::any('login', 'LoginController@login');
	Route::get('captcha', 'LoginController@captcha');
});
