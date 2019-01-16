<?php

// POSTS
Route::get('posts/create', 'CreatePostController@create')->name('posts.create');
Route::post('posts/create', 'CreatePostController@store')->name('posts.store');

// COMMENTS
Route::post('posts/{post}/comment', 'CommentController@store')->name('comments.store');
Route::post('comments/{comment}/accept', 'CommentController@accept')->name('comments.accept');

// Subscriptions
Route::post('posts/{post}/suscribe', 'SubscriptionController@subscribe')->name('posts.subscribe');
Route::delete('posts/{post}/suscribe', 'SubscriptionController@unsubscribe')->name('posts.unsubscribe');

Route::get('mis-posts/{category?}', 'ListPostController')->name('posts.mine');