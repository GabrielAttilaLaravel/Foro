<?php

// POSTS
Route::get('posts/create', 'CreatePostController@create')->name('posts.create');
Route::post('posts/create', 'CreatePostController@store')->name('posts.store');