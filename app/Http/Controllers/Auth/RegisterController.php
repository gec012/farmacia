<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Role;
use App\Perfil;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        /**validator :valida los campos del registro  */
        return Validator::make($data, [
            'documento'=> 'required|unique:users',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',    
            
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    
    protected function create(array $data)
    {
        /**aqui en la variable $roles cargo los roles*/

        $roles = Role::all();
        if($roles->isEmpty()){/**si $roles esta vacia ,crea los roles la primera vez  */
            $role = new Role();
            $role->name = 'admin';
            $role->description = 'Administrator';
            $role->estado= true;
            $role->save();
    
            $role = new Role();
            $role->name = 'soporte';
            $role->estado= false;
            $role->description = 'Soporte';
            $role->save();
    
            $role = new Role();
            $role->name = 'usuario';
            $role->description = 'Usuario';
            $role->estado= true;
            $role->save();
    
        }
        

		$user = new User();/**crea el usuario con datos del registro de usuario */
        $user->name = ucfirst($data['lastname']).', '.ucfirst($data['name']);
        $user->password = Hash::make($data['password']);
        $user->email = $data['email']; 
        $user->documento =  $data['documento'];     
        /**trae el adminitrador */
        $admin = User::where('rol',1)->get();
        
        if ($admin->isEmpty()) {/**si no existe administrador lo crea ,activa y valida su mail   */
            $user->rol = 1;            
            $user->email_verified_at=Carbon::now();
            $user->estado = true;      
            $user->save();
            $role_usuario  = Role::where('name', 'admin')->first(); 
            $user->roles()->attach($role_usuario);
            $user->save();
        } else {/**si existe administrador crea un usuario */
            $user->rol = 3;
            $user->estado = false;         
            $user->save();
            $role_usuario  = Role::where('name', 'usuario')->first();
            $user->roles()->attach($role_usuario);
            $user->save(); 
        }
        
        
        /**busca si existe el perfil del documento ingresado */
        $perfil = Perfil::where('perfil_id','like',$data['documento'])->get();
         

        if($perfil->isEmpty()){/**si no existe el titular lo crea */
            $perfil = new Perfil;
            $perfil->perfil_id = $data['documento'];
            $perfil->nombre = strtoupper($user->name);
            $perfil->save();
            $perfil->user_id = $user->id;
            $perfil->update();
        }else{/**si ya existe le añade el id del usuario nuevo */
            $per = $perfil->first();
            $per->nombre = strtoupper($user->name);
            $per->user_id = $user->id;
            $per->update();
        }

       

        return $user;
    }
}
