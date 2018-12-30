<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    function show(Post $post, $slug)
    {
        if ($post->slug != $slug){
            return redirect($post->url, 301);
        }

        return view('posts.show', compact('post'));
    }
}
