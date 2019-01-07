<?php

Route::get('register', 'RegisterController@create')->name('user.create');
Route::post('register', 'RegisterController@store')->name('user.store');
Route::get('register/confirmation', 'RegisterController@confirm')->name('user.confirm');

Route::get('login', 'LoginController@create')->name('login.create');
Route::post('login', 'LoginController@store')->name('login.sentToken');
