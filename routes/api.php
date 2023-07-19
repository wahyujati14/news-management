<?php

// use Illuminate\Http\Request;
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

// Route::group(['prefix' => 'auth'], function() use ($router) {
//     Route::post('/login', 'AuthController@login');
// });

// Route::middleware('auth:api')->group(function () {

//     Route::group(['prefix' => 'news'], function() use ($router) {
//         Route::get('/', 'NewsController@index');
//         Route::get('/:id', 'NewsController@detail');
//         Route::post('/add', 'NewsController@add');
//         Route::put('/edit', 'NewsController@edit');
//         Route::delete('/delete', 'NewsController@delete');
//     });

//     Route::group(['prefix' => 'comment'], function() use ($router) {
//         Route::post('/:news_id', 'CommentController@index');
//         Route::post('/add', 'CommentController@add');
//         Route::put('/edit', 'CommentController@edit');
//         Route::delete('/delete', 'CommentController@delete');
//     });

// });