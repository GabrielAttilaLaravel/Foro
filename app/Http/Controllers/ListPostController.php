<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class ListPostController extends Controller
{
    public function __invoke(Category $category = null, Request $request)
    {
        $routeStatus = [
            'posts.mine' => '',
            'posts.pending' => 'pendiente ',
            'posts.completed' => 'completado '
        ];

        $pending = $routeStatus[$request->route()->getName()]  ?? '';

        list($orderColumn, $orderDirection) = $this->getListOrder($request->orden);

        $posts = Post::query()
            // cargas ambiciosas
            ->with(['user', 'category'])
            ->when(auth()->check(), function ($q){
                $q->with(['userVote']);
            })
            ->category($category)
            ->scopes($this->getRouteScopes($request))
            ->orderBy($orderColumn, $orderDirection)
            ->paginate()
            ->appends($request->intersect(['orden']));

        return view('posts.index', compact('posts', 'category', 'pending'));
    }

    public function getRouteScopes(Request $request)
    {
        $scopes = [
            'posts.mine' => ['byUser' => [$request->user()]],
            'posts.pending' => ['pending'],
            'posts.completed' => ['completed']
        ];

        return $scopes[$request->route()->getName()] ?? [];
    }
    
    protected function getListOrder($orden)
    {
        $orders = [
            'recientes' => ['created_at', 'desc'],
            'antiguos' => ['created_at', 'asc'],

        ];

        return $orders[$orden] ?? ['created_at', ' desc'];
    }
}
