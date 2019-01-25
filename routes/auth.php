<?php

Route::post('logout', '\App\Http\Controllers\Auth\LoginController@logout')->name('logout');

// POSTS
Route::get('posts/create', 'CreatePostController@create')->name('posts.create');
Route::post('posts/create', 'CreatePostController@store')->name('posts.store');

// VOTES
Route::post('posts/{post}/vote/1', 'VotePostController@upvote');
Route::post('posts/{post}/vote/-1', 'VotePostController@downvote');
Route::delete('posts/{post}/vote', 'VotePostController@undoVote');

Route::post('comments/{comment}/vote/1', 'VoteCommentController@upvote');
Route::post('comments/{comment}/vote/-1', 'VoteCommentController@downvote');
Route::delete('comments/{comment}/vote', 'VoteCommentController@undoVote');

// COMMENTS
Route::post('posts/{post}/comment', 'CommentController@store')->name('comments.store');
Route::post('comments/{comment}/accept', 'CommentController@accept')->name('comments.accept');

// Subscriptions
Route::post('posts/{post}/suscribe', 'SubscriptionController@subscribe')->name('posts.subscribe');
Route::delete('posts/{post}/suscribe', 'SubscriptionController@unsubscribe')->name('posts.unsubscribe');

Route::get('mis-posts/{category?}', 'ListPostController')->name('posts.mine');