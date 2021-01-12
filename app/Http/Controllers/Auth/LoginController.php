<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/busqueda';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function authenticate()
    {
      $username = $request->email; //the input field has name='email' in form

        if(filter_var($username, FILTER_VALIDATE_EMAIL)) {
            //user sent their email  
           
            Auth::attempt(['email' => $username, 'password' => $password]);
        } else {
            //they sent their username instead 
           
            Auth::attempt(['id_user' => $username, 'password' => $password]);
        }

        //was any of those correct ?
        if ( Auth::check() ) {
            //send them where they are going 
            return redirect()->intended('dashboard');
        }

        //Nope, something wrong during authentication 
        return redirect()->back()->withErrors([
            'credentials' => 'Please, check your credentials'
        ]);
    }
}
