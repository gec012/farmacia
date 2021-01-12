<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->user()->authorizeRoles(['admin', 'soporte','usuario']);
        /**verifica que el usuario  no sea admin,soporte,usuario */
        if($request->user()->estado){/**si el esatdo del usuario es true  retorna a la vista busqueda */
            return redirect('busqueda');
        }else{/**si el estado del usuario es falso retorna a la vista login para que inicie sesion  */
            Auth::logout();
            return redirect('login');
        }
        
    }

    public function someAdminStuff(Request $request)
    {
        $request->user()->authorizeRoles('admin');

        return route('busqueda');
    }
}
