@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Register</div>
                <div class="panel-body">

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <h5>Por favor corrige los errores debajo:</h5>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form class="form-horizontal" role="form" method="POST" action="{{ route('user.store') }}">
                        {{ csrf_field() }}

                        {!! Field::email('email') !!}

                        {!! Field::text('username') !!}

                        {!! Field::text('first_name') !!}

                        {!! Field::text('last_name') !!}

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Registrate
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
