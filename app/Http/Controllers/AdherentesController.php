<?php

namespace App\Http\Controllers;


use Illuminate\Http\File;
use DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Imports\TitAdImport;
use Carbon\Carbon;
use App\TitularAdherente;
use App\Adherente;
use App\Perfil;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdherentesController extends Controller
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
    public function index()
    {/**carga  en $adherentes todos los adherentes del usuario logueado y devuelve  ala vista adherente.index */
        $adherentes=Adherente::where('perfil_id',Auth::user()->documento)->get();
       
        return view('adherente.index',compact('adherentes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
        if(Auth::user()->rol == 1){/**SI EL USUARIO LOGUEADO ES ADMINITRADOR DEVULVE A LA VISTA adherente.create  LA CUAL ES PARA CARGAR EL ARCHIVO DE ADHERENTES */

            return view('adherente.create');
        }else{/** SI NO ES ADMINITRADOR  RETORNA A LA VISTA  INICIAR SESSION(login)*/
            
            Auth::logout();
    
            return redirect('login');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
                if(Auth::user()->rol == 1){/**SI EL USUARIO QUE ESTA LOGUEADO ES ADMINISTRADOR  */
                    $file = $request->file('adherentefile');/**OBTIENE EL ARCHIVO  */
                    if( strtolower($file->getClientOriginalExtension()) == "xlsx"){/**VERIFICA LA EXTENSION VALIDA */
                 /**limpia la tabla auxiliar */
                    $titads = TitularAdherente::all();
                    foreach ($titads as $td) {
                        $td->delete();
                    }

                    /**TitAdImport  UTILIZA EL LA CARPETA app/imports/TitAdImport.php PARA LA IMPORTACION DEL EXCEL 
                         * A LA TABLA `titulares_y_adherentes` UTILIZANDO EL MODELO TitularAdherente TRAYENDO DESDE LA VISTA(adherente.create) EL ARCHIVO EXCEL
                         * 
                        */

                    $titads = Excel::import(new TitAdImport,$request->file('adherentefile'));
                    
                    $titads = TitularAdherente::all();

                    foreach ($titads as $tit){
                        if($tit->titular_dni == $tit->dni and  $tit->dni <> '88888888'){/** AQUI COMPLETO LA TABLA AGREGANDO TIT AL QUE NO LO TIENE */
                            $tit->tipo_adherente = 'TIT';
                           
                        }else{/**SI NO ES TIT LE AGREGAMMOS ADA */
                            $tit->tipo_adherente = 'ADA';                           
                        }
                        $tit->update();

                        if($tit->nombre == 'nom_adherente' or $tit->dni == '88888888'){/**AQUI ELIMINO LOS QUE TIENE DNI CON 88888888 O NOMBRE ADHERENTE QUE LA PRIMERA FILA DE LA TABLA EN EXCEL */
                            $tit->delete();
                        }

                    }

                    /**CARGO POR SEPARADO $titulares LOS TITULARES Y EN $adherentes LOS ADHERENTES  DE LA TABLA AUXILIAR (titulares_y_adherentes)*/
                    $titulares =  DB::select("SELECT titular_dni, nombre FROM titulares_y_adherentes WHERE tipo_adherente LIKE 'TIT' ");
                    $adherentes = DB::select("SELECT titular_dni,dni, nombre, tipo_documento,tipo_adherente,convenio FROM titulares_y_adherentes WHERE TRIM(tipo_adherente) <> 'TIT' ");
                    

                    foreach($titulares as $tit){/**RECORRO LA TABLA TITULARES */
                        $perfiles= Perfil::where('perfil_id',TRIM($tit->titular_dni))->get();/**PREGUNTO SI EXISTE EN DNI DEL TITULAR EN LA TABLA PERFIL Y LO CARGO EN LA VARIABLE $perfil */
                        if($perfiles->isEmpty()){/**SI $perfiles ESTA VACIA  CREO UN NUEVO PERFIL */
                           $perfil = new Perfil;
                           $perfil->perfil_id = TRIM($tit->titular_dni);
                           $perfil->nombre = TRIM($tit->nombre);
                           $perfil->save(); 
                        } 
                    } 

                   foreach($adherentes as $ad){/** RECORRO LA TABLA ADHERENTES*/
                        $adherentes2 = Adherente::where('dni',$ad->dni)->get();/**BUSCO EN LA TABLA ADHERENTE Y DEVUELVO EN LA VARIABLE $adherentes2 */
                        if($adherentes2->isEmpty()){/**PREGUNTO SI ESTA VACIA , SI ESTA VACIA CREO UN NUEVO ADHERENTE */
                            $adherente = new Adherente;
                            $adherente->perfil_id = $ad->titular_dni;
                            $adherente->nombre = $ad->nombre;
                            $adherente->dni = $ad->dni;
                            $adherente->tipo_documento = $ad->tipo_documento;
                            $adherente->tipo_adherente = $ad->tipo_adherente;
                            $adherente->convenio = $ad->convenio;
                            $adherente->save();
                        }
                    }

                   /**BORRO TODOS LOS REGISTRO DE LA TABLA AUXILIAR titulares_y_adherentes */
                    $titads = TitularAdherente::all();
                    
                    foreach ($titads as $ta) {
                        $ta->delete();
                    }
                    
                     /**RETORNO  A LA VISTA BUSQUEDA CON MSJ ARCHIVO CARGADO EXTIOSAMENTE  */                           
                    return  redirect('busqueda')->with('success','ARCHIVO CARGADO EXITOSAMENTE!!!!!!');

                }else{
                    /**SI NO ES UN ARCHIVO VALIDO DEVUELVE A LA VISTA ventas.create CON MSJ ARCHIVO NO SOPORTADO */
            return  view('ventas.create')->with('success','LA EXTENSION DEL ARCHIVO NO ES SOPORTADA ,CARGUE UN ARCHIVO CORRECTO!!!!!!!!');
                }

        }else{/**SI EL USUARIO LOGUEADO NO ES ADMINITRADO RETORNA A LA VISTA (login)  PARA EL INICIO DE SESSION */
            
            Auth::logout();
            
        return view('login');
        }
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
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
