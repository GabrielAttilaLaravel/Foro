@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h1>
                {{ $category->exists ? 'Post '.str_plural($pending, count($posts)) .' de '.$category->name : 'Posts' }}
            </h1>
        </div>
    </div>
    <div class="row">
        @include('posts.partials.sidebar')
        <div class="col-md-10">
            {!! Form::open(['method' => 'GET', 'class' => 'form form-inline']) !!}
                {!! Form::select(
                    'orden',
                    trans('options.posts-order'),
                    request('orden'),
                    ['class' => 'form-control']
                ) !!}

                <button type="submit" class="btn btn-default">Ordenar</button>
            {!! Form::close() !!}

            @each('posts.partials.items', $posts, 'post', 'posts.partials.empty')

            {{ $posts->render() }}
        </div>
    </div>
@endsection
