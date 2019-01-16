<?php

namespace App\Http\Controllers;

use App\Models\Post;

class ShowPostController extends Controller
{
    function __invoke(Post $post, $slug)
    {
        if ($post->slug != $slug){
            return redirect($post->url, 301);
        }

        return view('posts.show', compact('post'));
    }
}
