<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="{{ asset('img/osunsa.jpg') }}">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="{{ asset('https://fonts.googleapis.com/css?family=Nunito') }}"  srel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap4.min.css') }}">
    
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/all.css') }}">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        
        <script src="{{ asset('js/jquery.js') }}"></script>
        <script src="{{ asset('js/popper.min.js') }}"></script>
        <script src="{{ asset('js/bootstrap.min.js') }}"></script>
        
    <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>
   <script src="{{ asset('https://cdn.datatables.net/buttons/1.5.4/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('https://cdn.datatables.net/buttons/1.5.4/js/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js') }}"></script>
    <script src="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js') }}"></script>
    <script src="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js') }}"></script>
    <script src="{{ asset('https://cdn.datatables.net/buttons/1.5.4/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('https://cdn.datatables.net/buttons/1.5.4/js/buttons.print.min.js') }}"></script>
    
    <script src="{{ asset('js/date.min.js') }}" type="text/javascript"></script>
    <link href="{{ asset('https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css') }}" rel="stylesheet" type="text/css" />
   

</head>
<body style="background-color:#A4A4A4">
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark navbar-laravel"  style="background-color:#0B610B;">
            <div class="container">
                <a class="navbar-brand " href="{{ route('home') }}">
                    <img src="{{ asset('img/osunsa.jpg') }}" width="80px" height="40px" alt="" style="border-radius:20px;">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        @auth
                            @if (Auth::user()->estado == true and  Auth::user()->email_verified_at <> null )        
                                <li class="nav-item active">
                                    <a href="{{ route('busqueda') }}" class="nav-link"> Inicio </a>     
                                </li>
                                @if(Auth::user()->rol==3)
                                    <li class="nav-item ">
                                        <a href="{{ route('adherente.index') }}" class="nav-link">Adherentes</a>

                                    </li>
                                @endif
                            
                            @endif
                            
                            @if(Auth::user()->rol == 1)
                                                              
                            <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Cargar Archivo</a>
                                    <div class="dropdown-menu" style="background-color:#0B610B">
                                    <a href="{{ route('ventas.create') }}" class="nav-link"> Farmacia</a>
                                    <div class="dropdown-divider"></div>
                                    <a href="{{ route('adherente.create') }}" class="nav-link"> Adherentes </a>  
                                      </div>
                                  </li>
                               
                                             
                                
                               
                                             
                                
                                <li class="nav-item">
                                    <a href="{{ route('usuario.index') }}" class="nav-link"> Usuarios </a>     
                                </li>     
                            @endif
                        @endauth

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right"  aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
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

        <main class="py-4">
            <div class="container">
                    @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{ $message }}</p>
                    </div>
                @endif  
            </div>
            @yield('content')
        </main>
    </div>
</body>

</html>


    
   
    

   
