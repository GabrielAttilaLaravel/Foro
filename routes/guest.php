<?php

Route::get('register', 'RegisterController@create')->name('user.create');
Route::post('register', 'RegisterController@store')->name('user.store');
Route::get('register/confirmation', 'RegisterController@confirm')->name('user.confirm');

Route::get('login', 'TokenController@create')->name('token.create');
Route::post('login', 'TokenController@store')->name('token.sentToken');

Route::get('login/{token}', 'LoginController@login')->name('login');