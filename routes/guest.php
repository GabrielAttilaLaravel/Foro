<?php

Route::get('register', 'RegisterController@create')->name('user.create');
Route::post('register', 'RegisterController@store')->name('user.store');