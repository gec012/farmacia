
  <head>
        <link rel="shortcut icon" href="{{ asset('img/osunsa.jpg') }}">

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
    
        <title>{{ config('app.name', 'OSUNSa Documentacion') }}</title>
    
        <!-- Scripts -->
       
    
    
    
        <!-- Fonts -->
        
        <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css')}}" >
         
        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/all.css') }}">
        <link rel="stylesheet" href="{{ asset('css/barra1.css') }}">
    
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="css/sb-admin-2.css" rel="stylesheet">
    
    </head>
    

    <body style=" background-color:#0B610B; " >

        
 <nav class="navbar navbar-expand-md navbar-dark navbar-laravel"  style="background-color:#0B610B;">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ asset('img/osunsa.jpg') }}" width="80px" height="40px" alt="" style="border-radius:20px;">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
               

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    @guest
                      
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Registrarse') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                    {{ __('Cerrar Session') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
            <div class="container">
                    <div class="container">
                            @if ($message = Session::get('success'))
                            <div class="alert alert-success">
                                <p>{{ $message }}</p>
                            </div>
                        @endif  
                    </div>

            <!-- Outer Row -->
   <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-12 col-md-9">
        <br>
        <div class="card o-hidden border-0 shadow-lg my-5">

                <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                        <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                        <div class="col-lg-6">
                        <div class="p-5"> 
                                <div class="text-center">
                                                <h1 class="h4 text-gray-900 mb-4">Iniciar Sesión!</h1>
                                </div>
                    <form class="user" method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group">
                           

                            
                                <input id="email" type="email"  class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }} form-control-user" name="email" value="{{ old('email') }}" required  placeholder="Ingrese Correo Electronico...">
                             

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            
                        </div>

                        <div class="form-group ">
                            

                           
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }} form-control-user" name="password" required  placeholder="Ingrese Contraseña...">
                                
                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                          
                        </div>

                      
                        
                            
                                <button type="submit" class="btn btn-primary btn-user btn-dark btn-block" style="background-color:#212121;" >
                                       
                                        <strong> <i class="fas fa-sign-in-alt fa-1x"></i>  Iniciar</strong>
                                </button>
                                <hr>
                                <div class="form-group row mb-0">
                                    <div class="col-md-8 offset-md-4">
                                              
                                        @if (Route::has('password.request'))
                                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                                {{ __('¿ Olvido su Contraseña ?') }}
                                            </a>
                                        @endif
                                    </div>
                                </div>

                                
                              
                            
                       
                    </form>
                                        </div>
                                </div>

                    
                </div>
            </div>
        </div>
        </div>
    </div>
</div>


<script src="{{ asset('js/jquery.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js')}}"></script>
<script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<!-- Core plugin JavaScript-->
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>

<script>
        $(document).ready(function(){
          $('[data-toggle="tooltip"]').tooltip(); 
        });
</script>
<script src="{{ asset('js/barra1.js')}}"></script>
</body>