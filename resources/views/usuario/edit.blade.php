@extends('home')
@section('content')
<div class="container">
    
<div class="card text-center">
        <div class="card-header"  style="background-color:#0B610B;">
            <h2 class="card-title" style="color:#ccd4c2" >Editar Usuarios</h2>   
        </div>
    
        <div class="card-body"  >
            <div class="row"> 
                <a class="btn btn-success float-right" style=" border-radius: 20px;" href="{{ route('usuario.index') }}">Volver</a>
            </div>
            
            <form action="{{ route('usuario.update',$usuario->id)}}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                        <div class="form-group col-md-6 col-lg-6">
                                <strong for="name">Nombre</strong>
                                <input type="text" name="name" required class="form-control" style="border-radius:20px" value="{{$usuario->name}}">
                        </div>
                        <div class="form-group col-md-6 col-lg-6">
                                 <strong for="email">Email</strong>
                                 <input type="email" name="email" required class="form-control" style="border-radius:20px" value="{{$usuario->email}}">
                        </div>
                </div>
    
                <div class="row">
                    
                        <div class="form-group col-md-6 col-lg-6">
                                <strong for="password">Password</strong>
                                <input type="password" name="password"  class="form-control"  style="border-radius:20px">
                            </div>
    
                        <div class="form-group col-md-6 col-lg-6">
                                    <strong for="rol">Rol</strong>
                                    <select name="rol" id="" class="form-control" style="border-radius:20px">
                                        @foreach ($roles as $rol)
                                            @if ($usuario->hasRole($rol->name))                    
                                                <option value="{{ $rol->name}}" selected>{{ $rol->name }}</option>
                                            @else 
                                                <option value="{{ $rol->name}}">{{$rol->name}}</option> 
                                            @endif
                                        @endforeach
                                    </select>
                                </div> 
                </div>
    
                
           
    
                @if ( $usuario->email_verified_at == null)
                    <div class="row">
                            <div class="form-group col-md-12 col-lg-12 col-sm-12">
                                    <input class="form-check-input" type="checkbox" id="mail" name="mail">
                                    <label class="form-check-label" for="mail">
                                    Validar Email Manualmente
                                    </label>
                            </div>

                    </div>
                @endif
                                               
                <div class=" mt-4">
                    <input type="submit" value="Guardar" class="btn btn-success" style="border-radius:20px">
                </div>
            </form>
        </div>
    </div>         
          
</div>
@endsection