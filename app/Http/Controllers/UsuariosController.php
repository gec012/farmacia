<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Role;
use Illuminate\Support\Facades\Mail;
use App\Mail\OsunsaMail;  
use Carbon\Carbon;

use Illuminate\Support\Facades\Auth;
use DB;

class UsuariosController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)

    { 
       if(Auth::user()->rol == 1 )
        {
        $users= User::where('id','<>', Auth::user()->id)->paginate(7);
       
        return view('usuario.index',compact('users'));
    }
        
    }
       
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if(Auth::user()->rol == 1 ){
        $roles =Role::all()->pluck('name','id');
        
        
        return view('usuario.create',compact('roles'));}
         }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->user()->authorizeRoles(['admin']);

        $users=User::where('email',$request->email)->get();
        if( $users->isNotEmpty()){
        
            return back()->with('success','El correo ya existe,debe ingresar un correo nuevo');
        }
        $usuario =new User;
        $usuario->name =$request->name;
        $usuario->email =$request->email;
        $usuario->password = bcrypt($request->password);
        //creo los roles
        $role_admin= Role::where('name', 'admin')->first();
        $role_soporte = Role::where('name', 'soporte')->first();
        $role_usuario  = Role::where('name', 'usuario')->first();
        //busco el id del rol selecionado
        if($request->rol=='admin')
            $usuario->rol=1;
         if($request->rol=='soporte')
           $usuario->rol=2;
         if($request->rol=='usuario')
            $usuario->rol=3;
         $usuario->save();   
           //assign el rol
        $usuario->sectores()->attach($request->get('sector'));

           if($request->rol=='admin'){
           $usuario->roles()->attach($role_admin);
           }
           if($request->rol=='soporte'){
            $usuario->roles()->attach($role_soporte);
            }
            if($request->rol=='usuario'){
                $usuario->roles()->attach($role_usuario);
            }
         

           return redirect('/usuario');
          
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {
        $request->user()->authorizeRoles(['admin']);
        $usuario =User::find($id);
        //$roles =Role::all()->pluck('name','id');
      $roles = Role::where('estado',true)->get();
        return view('usuario.edit',compact('usuario','roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->user()->authorizeRoles(['admin']);
         $usuario=User::find($id);
         $usuario->name=$request->name;
         $usuario->email=$request->email;
         if($request->password){
         $usuario->password = bcrypt($request->password);
         }

         if($request->mail){
            $usuario->email_verified_at = Carbon::now();
        }
        

          //creo los roles
          $role_admin= Role::where('name', 'admin')->first();
          $role_soporte = Role::where('name', 'soporte')->first();
          $role_usuario  = Role::where('name', 'usuario')->first();
          
          //busco el id del rol selecionado
          if($request->rol=='admin')
              $usuario->rol=1;
           if($request->rol=='soporte')
             $usuario->rol=2;
           if($request->rol=='usuario')
              $usuario->rol=3;
           $usuario->save();   
             //elimino el rol anterior de la tabla muchos a muchos
             $usuario->roles()->detach($role_admin);
             $usuario->roles()->detach($role_soporte);
             $usuario->roles()->detach($role_usuario);


             //assign el rol
             if($request->rol=='admin'){
             $usuario->roles()->attach($role_admin);

             }
             if($request->rol=='soporte'){
              $usuario->roles()->attach($role_soporte);


              }
              if($request->rol=='usuario'){

               
                  $usuario->roles()->attach($role_usuario);
                
              }

            
              
             

             return redirect('/usuario');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        /**VERIFICO QUE EL USUARIO LOGUEADO SEA ADMINISTRADOR */
        $request->user()->authorizeRoles(['admin']);
        /**BUSCO EN LA TABLA USUARIOS EL EL ID INTERNO   */
        $usuario=User::find($id);
      
       if($usuario->estado){
        $usuario->estado= false;/** DESABILITO EL USUARIO */
       }else{
        $usuario->estado= true;/**HABILITO EL USUARIO ENVIANDO UN MAIL */
        $comment = 'Hola';
        $from = 'OSUNSa';
        $toEmail = $usuario->email;
        
        Mail::to($toEmail,$from.'hola')->send(new OsunsaMail($comment));
                
       }
        /**GUARDO EL USUARIO Y RETORNO A LA VISTA USUARIO (/usuario) */
       $usuario->save();
           return redirect('/usuario');
       }
        
}
