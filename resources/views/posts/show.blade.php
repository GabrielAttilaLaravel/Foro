@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-10">
            <h1>{{ $post->title }}</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <p>
                Publicado por <a href="#">{{ $post->user->name }}</a>
                {{ $post->created_at->diffForHumans() }}
                en <a href="{{ $post->category->url }}">{{ $post->category->name }}</a>.
                @if ($post->pending)
                    <span class="label label-warning">Pendiente</span>
                @else
                    <span class="label label-success">Completado</span>
                @endif
            </p>

            {!! $post->vote_component !!}

            {!! $post->safe_html_content !!}

            @if (auth()->check())
                @if (!auth()->user()->isSubscribedTo($post))
                    {!! Form::open(['route' => ['posts.subscribe', $post], 'method' => 'POST']) !!}
                        <button type="submit" class="btn btn-primary">Suscribirse al post</button>
                    {!! Form::close() !!}
                @else
                    {!! Form::open(['route' => ['posts.unsubscribe', $post], 'method' => 'DELETE']) !!}
                        <button type="submit" class="btn btn-default">Desuscribirse del post</button>
                    {!! Form::close() !!}
                @endif
            @endif

            <hr>

            <h4>Comentarios</h4>

            {{-- todo: Paginate comments! --}}

            @foreach($post->latestComments as $comment)
                <article class="comment {{ $comment->answer($post->answer_id) ? 'answer' : '' }}">
                    {{-- $comment->comment --}}
                    {!! $comment->safe_html_comment !!}

                    {!! $comment->vote_component !!}
                    {{--
                        verificamos si el usuario puede aceptar el comentario y este comentario no
                        esta ya marcado como la respuesta del post
                    --}}
                    @if(Gate::allows('accept', $comment) && !$comment->answer($post->answer_id))
                        {!! Form::open(['route' => ['comments.accept', $comment], 'method' => 'POST']) !!}
                            <button type="submit" class="btn btn-default">Aceptar respuesta</button>
                        {!! Form::close() !!}
                    @endif
                </article>

                <hr>
            @endforeach

            {!! Form::open(['route' => ['comments.store', $post], 'method' => 'POST', 'class' => 'form']) !!}

            {!! Field::textarea('comment', ['class' => 'form-control', 'rows' => 6, 'label' => 'Escribe un comentario']) !!}

            <button type="submit" class="btn btn-primary">
                Publicar comentario
            </button>

            {!! Form::close() !!}
        </div>
        @include('posts.partials.sidebar')
    </div>
@endsection
