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

Route::get('/home', 'HomeController@index');

Route::get('posts/{post}-{slug}', 'ShowPostController')->name('posts.show');

Route::get('posts-pendientes/{category?}', 'ListPostController')->name('posts.pending');
Route::get('posts-completados/{category?}', 'ListPostController')->name('posts.completed');
Route::get('{category?}', 'ListPostController')->name('posts.index');