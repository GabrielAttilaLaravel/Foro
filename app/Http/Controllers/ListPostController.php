<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class ListPostController extends Controller
{
    public function __invoke(Category $category = null, Request $request)
    {
        list($orderColumn, $orderDirection) = $this->getListOrder($request->orden);

        $posts = Post::query()
            ->with(['user', 'category'])
            ->scopes($this->getListScopes($category, $request))
            ->orderBy($orderColumn, $orderDirection)
            ->paginate()
            ->appends($request->intersect(['orden']));

        return view('posts.index', compact('posts', 'category'));
    }

    protected function getListScopes(Category $category, Request $request)
    {
        $scopes = [];

        $routeName = $request->route()->getName();

        if ($category->exists) {
            $scopes['category'] = [$category];
        }elseif ($routeName == 'posts.mine') {
            $scopes['byUser'] = [$request->user()];
        }elseif ($routeName == 'posts.pending') {
            $scopes[] = 'pending';
        }elseif ($routeName == 'posts.completed') {
            $scopes[] = 'completed';
        }
        return $scopes;
    }

    protected function getListOrder($orden)
    {
        if ($orden == 'recientes'){
            return ['created_at', 'desc'];
        }elseif ($orden == 'antiguos'){
            return ['created_at', 'asc'];
        }else{
            return ['created_at', 'desc'];
        }
    }
}
