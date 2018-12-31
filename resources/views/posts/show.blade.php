@extends('layouts.app')

@section('content')
    <h1>{{ $post->title }}</h1>

    <p>{{ $post->content }}</p>

    <p>{{ $post->user->name }}</p>

    {!! Form::open(['route' => ['comments.store', $post], 'method' => 'POST']) !!}

        {!! Field::textarea('comment') !!}
        <button type="submit">
            Publicar comentario
        </button>

    {!! Form::close() !!}
    {{-- TODO: listar los comentarios y mostrar el author del mismo --}}
    @foreach($post->latestComments as $comment)
        <article class="{{ $comment->answer ? 'answer' : '' }}">
            {{ $comment->comment }}
            {!! Form::open(['route' => ['comments.accept', $comment], 'method' => 'POST']) !!}
            <button type="submit">Aceptar respuesta</button>
            {!! Form::close() !!}
        </article>
    @endforeach
@endsection
