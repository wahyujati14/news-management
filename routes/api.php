<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['prefix' => 'auth'], function() use ($router) {
    Route::post('/login', 'AuthController@login');
});

Route::group(['middleware' => 'token'], function() use ($router) {

    Route::group(['middleware' => 'role:ADMIN', 'prefix' => 'news'], function() use ($router) {
        Route::get('/', 'NewsController@index');
        Route::get('/{id}', 'NewsController@show');
        Route::post('/add', 'NewsController@store');
        Route::post('/edit/{id}', 'NewsController@update');
        Route::delete('/delete/{id}', 'NewsController@delete');
    });

    Route::group(['prefix' => 'comment'], function() use ($router) {
        Route::post('/add/{news_id}', 'CommentController@store');
        Route::post('/edit/{id}', 'CommentController@update');
        Route::delete('/delete/{id}', 'CommentController@delete');
    });
    
});