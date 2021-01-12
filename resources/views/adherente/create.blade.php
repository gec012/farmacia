@extends('home')
@section('content')

@if (count($errors) < 0)
    <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                     <li>{{ $error }}</li>
                @endforeach
            </ul>
    </div>
@endif

<div class="container">

                
        <div class="card text-center">
                        <div class="card-header"  style="background-color:#0B610B;">
                                <h2 class="card-title" style="color:#ccd4c2" > Cargar un nuevo archivo de adherentes</h2>
                                @if ($message = Session::get('success'))
                                        <div class="alert alert-warning">
                                                <p>{{ $message }}</p>
                                        </div>
                                @endif
                        </div>
                
                        <div class="card-body" >
                        
                       
                                {!! Form::open( ['method' => 'POST','files' => true,'route' => ['adherente.store']]) !!}
                                        @include('adherente.form')
                                {!! Form::close() !!}
                        </div>
                </div>
</div>

@endsection