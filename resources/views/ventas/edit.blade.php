@extends('home')
@section('content')
@if (count($errors) > 0)

    <div class="alert alert-danger">
        <ul>    
            <strong>Whoops!</strong> There were some problems with your input.
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card text-center">
        <div class="card-header"  style="background-color:#212121">
                <h2 class="card-title" style="color:#ccd4c2" >Editar Tipo</h2>
    
        </div>
    <div class="card-body"  style="background-color:#ccff90 ;">
            <div class="row"> 

                    <a class="btn btn-dark float-right" style=" border-radius: 20px;" href="{{ route('tipo.index') }}">Volver</a>
            </div>
    {!! Form::model($tipo,[ 'method'=> 'PATCH','route'=>['tipo.update', $tipo->id]]) !!}

    @include('tipo.form')
    {!! Form::close() !!}
    </div>
</div>
@endsection
