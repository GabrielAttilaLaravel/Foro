@extends('layouts.app')

@section('content')
    <h1>Post</h1>

    <ul>
        @foreach($posts as $post)
            <li><a href="{{ $post->url }}">{{ $post->title }}</a></li>
        @endforeach
    </ul>

    {!! $posts->render() !!}
@endsection
