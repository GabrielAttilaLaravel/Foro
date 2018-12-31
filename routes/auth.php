<?php

// POSTS
Route::get('posts/create', 'CreatePostController@create')->name('posts.create');
Route::post('posts/create', 'CreatePostController@store')->name('posts.store');

// COMMENTS
Route::post('posts/{post}/comment', 'CommentController@store')->name('comments.store');
Route::post('comments/{comment}/accept', 'CommentController@accept')->name('comments.accept');