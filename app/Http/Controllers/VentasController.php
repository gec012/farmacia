<?php

namespace App\Http\Controllers;


use Illuminate\Http\File;
use DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Imports\VentasImport;
use App\Imports\PerfilImport;
use Carbon\Carbon;
use App\Venta;
use App\Perfil;
use App\Factura;
use App\DetalleFactura;
use App\Adherente;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PDF;


class VentasController extends Controller
{
    public function __construct()
    {
        /*ESTE CONSTRUCTOR ES PARA USAR EL middleware DE VERIFICACION DE CUENTAS Y AUTENTICACION */
        $this->middleware(['auth', 'verified']);
       
    }


    /**
     * Display a listing of the resource.
     *
     * 
     */
    public function index(Request $request)
    {

       
       
       /* RECUPERA FECHAS DE BUSQUEDA DE LA VISTA busqueda */
        $inicio =  Carbon::create($request->get('inicio'));
        $fin = Carbon::create($request->get('fin'));

        $f =  Carbon::create('2019-01-01');

        if($inicio == $fin and $fin == $f and (Auth::user()->rol == 3  or Auth::user()->rol == 1 )and Auth::user()->estado ){
            return redirect('busqueda');
        }
     
       /*REALIZA LA DIFERENCIA DE $inicio Y $fin Y VERFIFICA SI EN MENOR QUE 96 DIAS O MAYOR IGUAL QUE CERO( NO SEA NEGATIVA) */ 
        if ($inicio->diffInDays($fin) < 96  and $inicio->diffInDays($fin,false) >= 0 ){
               
                /*DA FORMATOS A LAS FECHA EN (AÑOS, MES , DIA ), PARA QUE MYSQL PUEDA TRABAJAR SIN ERRORES */                    
                $inicio = $inicio->format('Y-m-d');                
                $fin = $fin->format('Y-m-d');
                /*REALIZA UNA COPIA DE $fin Y LE AÑADE UN DIA PARA PODER REALIZAR LAS CONSULTAS */
                $finB =  Carbon::create($fin); 
                $finB = $finB->addDay();

       
            
        if(Auth::user()->rol == 1){ /*SOLO PARA ROL=1 ES DECIR ADMINISTRADOR */

                /* $facturas TRAE TODAS LAS FACTURAS DE LOS TITULARES(tabla perfil) DEL SISTEMA $inicio Y $fin  EN FORMATO DE ARRAY*/
                $facturas = DB::select("SELECT fac.id, fac.perfil_id,fac.sucursal, per.nombre, fac.fecha, fac.numero_factura , fac.total_pagado 
                                    FROM facturas as fac 
                                    INNER JOIN  perfil as per ON fac.perfil_id = per.perfil_id 
                                    WHERE fac.fecha >= '$inicio' 
                                    AND fac.fecha <= '$finB'
                                    ORDER BY fac.fecha desc ");

                /* $facturas TRAE TODAS LAS FACTURAS DE LOS ADHERENTES (tabla adherentes) DEL SISTEMA $inicio Y $fin  EN FORMATO DE ARRAY*/                    
                $facturasAd = DB::select("SELECT fac.id, fac.perfil_id, fac.sucursal, ad.nombre, fac.fecha, fac.numero_factura , fac.total_pagado 
                                    FROM facturas as fac 
                                    INNER JOIN  adherentes as ad ON fac.perfil_id = ad.dni 
                                    WHERE fac.fecha >= '$inicio' 
                                    AND fac.fecha <= '$finB'
                                    ORDER BY fac.fecha desc ");
          
                    

          if(count($facturas) > 0 or count($facturasAd) > 0){/*VERIFICA QUE AL MENOS EXISTA UNA FACTURA ENTRE LOS DOS ARRAY */
                        /* DA FORMATO DE FECHAS CON CARBON PARA ENVIARLAS A LA VISTA Y PODER FORMATERLAS AHI */
                        foreach ($facturas as $factura) {
                            
                            $factura->fecha = Carbon::create($factura->fecha);
                        }
                        foreach ($facturasAd as $factura) {
                            $factura->fecha = Carbon::create($factura->fecha);
                        }  

                        /* RETORNA A LA VISTA ventas/index CON LAS VARIABLES $facturas, $facturasAd, $inicio , $fin */
                        return view('ventas.index',compact('facturas','facturasAd','inicio','fin'));
                        
                    }
                    else{/*SI AMBOS ARRAY ESTAN VACIOS ENVIA EL $mensaje  A LA VISTA busqueda */
                        $inicio = Carbon::create($inicio);
                        $fin = Carbon::create($fin);
                        $inicio = $inicio->format('d-m-Y');
                        $fin = $fin->format('d-m-Y');
                        if($inicio==$fin){
                            $mensaje = 'No hay Consumos el '. $fin;
                        }else{

                            $mensaje = 'No hay Consumos entre '.$inicio.' y '. $fin;

                        }

                        return redirect('busqueda')->with('success',$mensaje );
                    }
        }else{/* SI NO ES ADMINISTRADOR  */
            if(Auth::user()->rol == 3 and Auth::user()->estado == true){/*PREGUNTA QUE SEA USUARIO Y ADEMAS QUE SU CUENTA ESTE VERIFICADA */

                $perfiles =Perfil::where('user_id', Auth::user()->id)->get();
                $perfil = $perfiles->first();

               $facturas = DB::select("SELECT fac.id, fac.perfil_id, fac.sucursal, per.nombre, fac.fecha, fac.numero_factura , fac.total_pagado 
                        FROM facturas as fac 
                        INNER JOIN  perfil as per ON fac.perfil_id = per.perfil_id 
                        WHERE fac.perfil_id = '$perfil->perfil_id'
                        AND fac.fecha >= '$inicio' 
                        AND fac.fecha <= '$finB'
                        ORDER BY fac.fecha desc ");

                $facturasAd = DB::select("SELECT fac.id, fac.perfil_id, fac.sucursal, ad.nombre, fac.fecha, fac.numero_factura , fac.total_pagado 
                        FROM facturas as fac 
                        INNER JOIN  adherentes as ad ON fac.perfil_id = ad.dni 
                        WHERE fac.perfil_id IN (SELECT ad.dni FROM adherentes as ad WHERE ad.perfil_id = '$perfil->perfil_id'
                        )                        
                        AND fac.fecha >= '$inicio' 
                        AND fac.fecha <= '$finB'
                        ORDER BY fac.fecha desc ");
                                        
               

                        
                        if(count($facturas) > 0 or count($facturasAd) > 0){
                            foreach ($facturas as $factura) {
                                $factura->fecha = Carbon::create($factura->fecha);
                            }
                            foreach ($facturasAd as $factura) {
                                $factura->fecha = Carbon::create($factura->fecha);
                            }  
                            $adherentes=Adherente::where('perfil_id',Auth::user()->documento)->get();
                            
                            return view('compras.index',compact('facturas','facturasAd','perfil','adherentes','inicio','fin'));
                            
                        } else{
                            
                            /*SI AMBOS ARRAY ESTAN VACIOS ENVIA EL $mensaje  A LA VISTA busqueda */
                            $inicio = Carbon::create($inicio);
                            $fin = Carbon::create($fin);
                            $inicio = $inicio->format('d-m-Y');
                            $fin = $fin->format('d-m-Y');
                            if($inicio==$fin){
                                $mensaje = 'No hay Consumos el '. $fin;
                            }else{

                                $mensaje = 'No hay Consumos entre '.$inicio.' y '. $fin;
    
                            }
                            return redirect('busqueda')->with('success',$mensaje );
                        }      

            }else{/** SI EL USUARIO NO ESTA ACTIVO O NO ESTA LOGUEADO */

                if(Auth::user()->rol == 3){/**SI ESTA LOGUEADO Y ES USUARIO DEVUELVE A LA VISTA AVISO DONDE LE INDICA QUE SU CUENTA NO ESTA ACTIVA.*/
                    return view('aviso');
                }else{/**SI NO ESTA LOGUEADO VUELVE  A INICIAR SESSION(LOGIN)  */
                    return redirect('login');
                }
            }
        }
    }else{/**LA VARIABLES DE BUSQUEDA DE $inicio $fin SUPERAN LOS 96 DIAS O ESTAN PUESTAS AL REVES  */
        
        if($inicio->diffInDays($fin,false) < 0){/**SI ESTAN AL REVES DEVUELVE $mensaje a la VISTA BUSQUEDA */
           
            $inicio = $inicio->format('d-m-Y');
            $fin = $fin->format('d-m-Y');
            $mensaje = 'La fecha de inicio:  '.$inicio.', no puede ser mayor que la de fin '. $fin;

            return redirect('busqueda')->with('success',$mensaje );
        }else {/**SI SUPERAN LOS 96 DIAS  DEVUELVE a busqueda con mensaje(success) */
         
        return redirect('busqueda')->with('success','Su busqueda tiene un intervalo de muchos dias, Realize una nueva busqueda con menor un intervalo como maximo 3 meses' );
   
        }
    }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         if(Auth::user()->rol == 1){/**si es administrador carga las fechas distintas  separadas por mes , años  y las disnitinas sedes en $Fechas a la vista ventas.create   */
                $fechas = DB::select("SELECT DISTINCT trim( date_format(f.fecha, '%m-%Y') ) as fecha ,f.sucursal  FROM facturas as f");
                            
                return view('ventas.create',compact('fechas'));
         }else{//**SI NO ES ADMINISTRADOR  DEVUELVE A INICIAR SESSION (login) */

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


        if(Auth::user()->rol == 1){/**S ES ADMINISTRADOR */
            
                        $file = $request->file('ventasfile'); /**TRAE EL ARCHIVO DE LA VISTA(ventas/create) */
                        if( strtolower($file->getClientOriginalExtension()) == "xlsx"){/* SI EL ARCHIVO ES DE EXTENSION .xlsx  */
                       
                            /**LIMPIA LA TABLA ventas   QUE ES UNA TABLA AUXILIAR  */
                            $ventas = Venta::all();

                            foreach ($ventas as $venta) {
                                $venta->delete();
                            }

                        /**VENTAS IMPORT UTILIZA EL LA CARPETA app/imports/VentasImport.php PARA LA IMPORTACION DEL EXCEL 
                         * A LA TABLA VENTAS UTILIZANDO EL MODELO VENTA TRAYENDO DESDE LA VISTA(ventas/create) EL ARCHIVO EXCEL
                         * 
                        */
                        $ventas = Excel::import(new VentasImport,$request->file('ventasfile'));
                        
                        /*Venta::all() trea todas las ventas en la tabla(ventas) y la pone en una coleccion de laravel que es la variable($ventas)  */
                        $ventas = Venta::all();

                        

                        foreach ($ventas as $venta) {

                            if(trim($venta->Cliente) == 'Cliente' or trim($venta->Cliente) == '' ){ /* Elimina la primera fila del archivo (cabecera) y la ultima de la tabla venta */                                   
                                $venta->delete();
                            }else{
                                
                                $factura=Factura::where('numero_factura','like', $venta->T.'-'.$venta->Suc.'-'.$venta->Número)->get();
                                if($factura->isEmpty()){  /** aqui preguntamos si la variable(Collecion de laravel) $factura esta vaciam creamos una nueva factura*/
                              
                                    $factura = new Factura;
                                    /**buscamos el perfil de la factura  */
                                    $perfil = Perfil::where('perfil_id',$venta->user_id)->get();
                                    
                                    if($perfil->isEmpty()){/**si el perfil no existe, buscamos si es de un adherente */
                                        $adherente = Adherente::where('dni',$venta->user_id)->get(); 
                                        if($adherente->isEmpty()){/**si el adherente no existe es decir que es un perfil y lo creamos */
                                            $perfil = new Perfil;
                                            $perfil->perfil_id = $venta->user_id;
                                            $perfil->nombre = $venta->Cliente;
                                            $perfil->save();
                                        }                                       
                                    }
                                    /**LE PONEMOS A LA FACTURAS EL PERFIL_ID DE LA VENTA */
                                    $factura->perfil_id = $venta->user_id;
                                    /**ESTA CONVERSION DE FECHAS ES PARA DARLE FORMATOS Y PODER CONVERTIR EL STRING QUE SE CARGA POR DEFECTO A UN TIPO FECHA() */
                                    $fecha = explode('/',$venta->Fecha);
                                    $anio = substr($fecha[2],0,2);
                                    $horas = substr($fecha[2],3,-1);
                                    $day= $anio.'-'.$fecha[1].'-'.$fecha[0].' '.$horas;                    
                                    $factura->fecha = Carbon::create($day);
                                    
                                    /*TERMINAMOS DE CARGAR LAS FACTURAS */
                                    $factura->numero_factura = $venta->T.'-'.$venta->Suc.'-'.$venta->Número;
                                    $factura->sucursal = $venta->sucursal;
                                    $factura->total_pagado = $venta->Tot_Cliente;
                                    $factura->save();

                                    /*CREAMOS EL DETALLE DE LA FACTURA Y LO VAMOS CARGANDO DESDE LA VARIABLE VENTA */
                                    $detalle = new DetalleFactura;
                                    $detalle->factura_id = $factura->id;
                                    $detalle->Total_Neto_Renglón = $venta->Total_Neto_Renglón;
                                    $detalle->Cobertura =$venta->Cobertura;
                                    $detalle->Tot_Cliente = $venta->Tot_Cliente;
                                    $detalle->Obra_Social= $venta->Obra_Social;
                                    $detalle->Rubro = $venta->Rubro;
                                    $detalle->Producto = $venta->Producto;
                                    $detalle->Cant = $venta->Cant;
                                    $detalle->Total_Bruto_Renglón = $venta->Total_Bruto_Renglón;
                                    $detalle->Dto_Adic = $venta->Dto_Adic;
                                    $detalle->save();

                                }else{/**SI LA FACTURA YA EXISTE */
                                    $fac = $factura->first();/**COMO ES UNA COLLECION DE LARAVEL LA CONSULTA DE ELCUENT NECESITAMOS SACAR LA FACTURA 
                                    AUNQUE SEPAMOS QUE ES UNICA POR ESO USAMOS FIRST QUE  ES UN METODO POR DEFECTO DE LAS COLLECIONES,
                                    A CONTINUACION CREAMOS EL SIGUEINE DETALLE QUE LE PERTENECE A DICHA FACTURA */
                                    $detalle = new DetalleFactura;
                                    $detalle->factura_id = $fac->id;
                                    $detalle->Total_Neto_Renglón = $venta->Total_Neto_Renglón;
                                    $detalle->Cobertura =$venta->Cobertura;
                                    $detalle->Tot_Cliente = $venta->Tot_Cliente;
                                    $detalle->Obra_Social= $venta->Obra_Social;
                                    $detalle->Rubro = $venta->Rubro;
                                    $detalle->Producto = $venta->Producto;
                                    $detalle->Cant = $venta->Cant;
                                    $detalle->Total_Bruto_Renglón = $venta->Total_Bruto_Renglón;
                                    $detalle->Dto_Adic = $venta->Dto_Adic;
                                    $detalle->save();

                                    /**VA CALCULANDO EL TOTAL PAGADO DE LA FACTURA SEGUN EL DETALLE */
                                    $fac->total_pagado = $fac->total_pagado+$venta->Tot_Cliente;
                                    $fac->update();
                                
                                }
                                    



                                }
                        }/**FIN DEL FOREACH $ventas TEMINA LA CARGA DE FACTURAS Y LOS DETALLES */      
                                
                        
                                
                                /**LIMPIA LA TABLA AUXILIAR(ventas) */
                                foreach ($ventas as $venta) {
                                    $venta->delete();
                                }

                                /** carga las fechas distintas  separadas por mes , años  y las disnitinas sedes en $Fechas a la vista ventas.create 
                                 * CON EL MENSAJE DE EXITO EN LA CARGA
                                 */
                                $fechas = DB::select("SELECT DISTINCT trim( date_format(f.fecha, ' %m-%Y') ) as fecha ,f.sucursal  FROM facturas as f");
      
                        return  view('ventas.create',compact('fechas'))->with('success','ARCHIVO CARGADO EXITOSAMENTE!!!!!!');

                    }else{
                         /** carga las fechas distintas  separadas por mes , años  y las disnitinas sedes en $Fechas a la vista ventas.create 
                                 * CON EL MENSAJE DE EXTENSON DE ARCHIVO NO VALIDA
                                 */
                        $fechas = DB::select("SELECT DISTINCT trim( date_format(f.fecha, ' %m-%Y') ) as fecha ,f.sucursal  FROM facturas as f");
       
                    return  view('ventas.create',compact('fechas'))->with('success','LA EXTENSION DEL ARCHIVO NO ES SOPORTADA ,CARGUE UN ARCHIVO CORRECTO!!!!!!!!');
                    }
                     /** carga las fechas distintas  separadas por mes , años  y las disnitinas sedes en $Fechas a la vista ventas.create 
                                 * CON EL MENSAJE DE EXITO EN LA CARGA
                                 */
                    $fechas = DB::select("SELECT DISTINCT trim( date_format(f.fecha, ' %m-%Y') ) as fecha ,f.sucursal  FROM facturas as f");
       
            return view('ventas.create',compact('fechas'));
        }else{
            /**SI NO ES ADMINISTRADO LO ENVIA  A LA  VISTA login cerrandole la sesion */
            
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
    public function show($id,Request $request)
    {
        /*
        *   TREA LA FECHA DE LA BUSQUEDA PARA NO PERDERLAS
        */
        $inicio = $request->inicio;
        $fin = $request->fin;
       
        if(Auth::user()->rol == 1){/**SI ES ADMINISTRADOR */
            /**BUSCA LA FACTURA POR LA VARIABLE QUE LLEGA($id) Y TRAE TODOS SUS DETALLES */
            $factura = Factura::find($id);
            $detalles= DetalleFactura::where('factura_id',$id)->get();

            $perfiles = Perfil::where('perfil_id',$factura->perfil_id)->get();
            if($perfiles->isEmpty()){/**BUSCA EL PERFIL DE TITULAR CON EL DOCUMENTO EN LA FACTURA Y VERIFICA, SI NO EXISTE LO BUSCA EN ADHERENTES */
                $perfiles = Adherente::where('dni',$factura->perfil_id)->get();
            }
            /**POR SER UNA COLLECION DE LARAVEL LO QUE TREA LA CONSULTA DE ELOCUENT AUNQUE SEPAMOS QUE POSEE UN SOLO ELEMNTO NECEISTAMOS SACARLO DE LA COLLECION Y USAMOS (first()) */
            $perfil = $perfiles->first();
            /**le da formato de time a las fechas para evitar errores en la vista */
            $factura->fecha = Carbon::create($factura->fecha);
            /**DEVUELVE A LA VISTA(ventas.show), para mostrar la factura y sus detalles con las variables (factura','detalles','perfil','inicio','fin) */
            return  view('ventas.show',compact('factura','detalles','perfil','inicio','fin'));
        }else{
            if(Auth::user()->rol == 3){/** SI ES UN USUARIO  */
                /**BUSCA LA FACTURA POR LA VARIABLE QUE LLEGA($id) Y TRAE TODOS SUS DETALLES */
                $factura = Factura::find($id);
                $detalles= DetalleFactura::where('factura_id',$id)->get();
                /**BUSCA EL PERFIL DE USUARIO LOGUEADO Y EL DE SUS ADHERENTES */
                $perfiles = Perfil::where('user_id',Auth::user()->id)->get();
                $adherentes= Adherente::where('perfil_id',Auth::user()->documento)->get();
                
                /**RECUPERA LE PERFIL */
                $perfil = $perfiles->first();
              
                if($perfil->perfil_id == $factura->perfil_id){/**COMPARA SI ES EL MISMO QUE EL DE LA FACTURA Y LA ENVIA A LA VISTA FACTURAS */
                    $factura->fecha = Carbon::create($factura->fecha);
                    return  view('ventas.show',compact('factura','detalles','perfil','inicio','fin'));
                }else{/**SI NO ES EL MISMO BUSCA DE CUAL DE SUS ADHERENTES ES Y LO ENVIA A LA VISTA */

                    foreach($adherentes as $ad){
                        if($ad->dni == $factura->perfil_id){
                            $factura->fecha = Carbon::create($factura->fecha);
                            $perfil = $ad;
                            return  view('ventas.show',compact('factura','detalles','perfil','inicio','fin'));
                        }
                    }/**SI NO ES DE ALGUNO DE SUS ADHERENTE O PROPIA LOS ENVIA A BUSQUEDA  */
                    return redirect('busqueda');
                }
            }else{/** SI NO ES UN USUARIO LOGUEADO */
                return view('login');
            }
        }
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
    public function destroy($fecha)
    {
        if(Auth::user()->rol == 1){/**SI ES ADMINISTRADO PUEDE ELIMINAR LAS FACTURAS Y SUS DETALLES  Y NOS DEVUELVE A LA VISTA ventas.create CON MSJ ARCHIVO ELIMINADO EXITOSAMENTE*/
        $list= explode(' ',$fecha);
        $ventas=db::select("SELECT * from facturas as f
                                    WHERE date_format(f.fecha, '%m-%Y')='$list[0]' 
                                    AND f.sucursal='$list[1]' ");
        
        foreach($ventas as $v) {
                $detalles= DetalleFactura::where('factura_id',$v->id)->get();

                foreach($detalles as $dt){
                    $dt->delete();
                }
                $f = Factura::find($v->id);
                $f->delete();

            
            
       }
       
       $fechas = DB::select("SELECT DISTINCT trim( date_format(f.fecha, ' %m-%Y') ) as fecha ,f.sucursal  FROM facturas as f");
                             
            return view('ventas.create',compact('fechas'))->with('success','ARCHIVO ELIMINADO EXITOSAMENTE!!!!!!');
    }else{/**SI NO ES ADMINISTRADOR DEVUELVE A LA VISTA busqueda     */
        return redirect('busqueda');
        
    }
     }


    public function generatePDF(Request $request){


       /* RECUPERA FECHAS DE BUSQUEDA(fechas )*/
        /*DA FORMATOS A LAS FECHA EN (AÑOS, MES , DIA ), PARA QUE MYSQL PUEDA TRABAJAR SIN ERRORES */                    
              
        $inicio =  Carbon::create($request->get('inicio'));
        $inicio = $inicio->format('Y-m-d');
        $fin = Carbon::create($request->get('fin'));
        $fin = $fin->format('Y-m-d');
    
        /*REALIZA UNA COPIA DE $fin Y LE AÑADE UN DIA PARA PODER REALIZAR LAS CONSULTAS */
              
        $finB =  Carbon::create($fin);
        $finB = $finB->addDay();

        /**trae el perfil de usuario logueado */    
        $perfiles =Perfil::where('user_id', Auth::user()->id)->get();
        $perfil = $perfiles->first();
          
        /* $facturas TRAE TODAS LOS DETALLES DE LAS FACTURAS DEL TITULAR(tabla perfil) DEL SISTEMA $inicio Y $fin  EN FORMATO DE ARRAY*/
        $facturas = DB::select("SELECT fac.id, df.id,per.nombre, fac.perfil_id, fac.sucursal, fac.fecha, fac.numero_factura , df.Producto,
                    df.Total_Neto_Renglón ,df.Tot_Cliente, df.Rubro, df.Cant, df.Total_Bruto_Renglón
                    FROM facturas as fac 
                    INNER JOIN  perfil as per ON fac.perfil_id = per.perfil_id 
                    INNER JOIN detallefacturas AS df ON df.factura_id = fac.id  
                    WHERE fac.perfil_id = '$perfil->perfil_id'
                    AND fac.fecha >= '$inicio' 
                    AND fac.fecha <= '$finB'
                    GROUP BY 1,2
                    ORDER BY fac.fecha desc ");
                    
        /* $facturas TRAE TODOS LOS DETALLES DE LAS FACTURAS DE SUS ADHERENTES (tabla adherentes) DEL SISTEMA $inicio Y $fin  EN FORMATO DE ARRAY*/                                
        $facturasAd = DB::select("SELECT fac.id, df.id,ad.nombre, fac.perfil_id, fac.sucursal, fac.fecha, fac.numero_factura , df.Producto,
                              df.Total_Neto_Renglón ,df.Tot_Cliente, df.Rubro, df.Cant, df.Total_Bruto_Renglón
                    FROM facturas as fac 
                    INNER JOIN  adherentes as ad ON fac.perfil_id = ad.dni 
                    INNER JOIN detallefacturas AS df ON df.factura_id = fac.id 
                    WHERE fac.perfil_id IN (SELECT ad.dni FROM adherentes as ad WHERE ad.perfil_id = '$perfil->perfil_id')
                    AND fac.fecha >= '$inicio' 
                    AND fac.fecha <= '$finB'
                    ORDER BY fac.fecha desc ");            
                
                /*VERIFICA QUE AL MENOS EXISTA UNA FACTURA ENTRE LOS DOS ARRAY */
                /* DA FORMATO DE FECHAS CON CARBON PARA ENVIARLAS A LA VISTA Y PODER FORMATERLAS AHI */   
                    if(count($facturas) > 0 or count($facturasAd) > 0){
                        foreach ($facturas as $factura) {
                            $factura->fecha = Carbon::create($factura->fecha);
                        }
                        foreach ($facturasAd as $factura) {
                            $factura->fecha = Carbon::create($factura->fecha);
                        } 
                        $inicio =  Carbon::create($inicio);
                        $fin = Carbon::create($fin);
                        /**carga la vistas compras indformes y las convierte en PDF USUANDO DOMPDF */
                        $pdf = PDF::loadView('compras.informe', compact('facturas','facturasAd','inicio','fin'));
                
                        /**REALIZA LA DESCARGA DEL PDF CON UN NOMBRE ESPECIFICADO */
                        return $pdf->download('misconsumos.pdf');
                    }else {
                        return view('busqueda');
                    }


    }

    public function ImprimirFactura($id){
        
        /**BUSCA LA FACTURA Y SUS DETALLES */
        $factura = Factura::find($id);
        $detalles= DetalleFactura::where('factura_id',$id)->orderby('Producto','asc')->get();

        if (Auth::user()->rol == 1) {/**SI ES ADMINISTRADOR */
            
            /**BUSCA EL PERFIL DEL DUEÑO DE LA FACTURA */
            $perfiles = Perfil::where('perfil_id',$factura->perfil_id)->get();
               
           
            if ($perfiles->isNotEmpty()) {/**SI ES DE UN TITULAR CREA EL PDF Y DESCARGA LA FACTURA USANDO LA VISTA compras.factura */
                $perfil = $perfiles->first();
                $tit = null;
                if($perfil->perfil_id == $factura->perfil_id){
                    $factura->fecha = Carbon::create($factura->fecha);
                    $pdf = PDF::loadView('compras.factura',compact('factura','detalles','perfil','tit'));
                    return $pdf->download('comprobante_NRO'.'_'.$factura->numero_factura.'.pdf');
                }
            }else {/**SI NO ES UN TITULAR BUSCA AL ADHERENTE, DE ESE ADHERENTE TRAE EL TITULAR Y CREA EL PDF Y DESCARGA LA FACTURA USANDO LA VISTA compras.factura */
                $adherentes = Adherente::where('dni',$factura->perfil_id)->get();
                $perfil = $adherentes->first();
                $titular = Perfil::where('perfil_id', $perfil->perfil_id)->get();
                $tit = $titular->first();
                if($perfil->dni == $factura->perfil_id){
                    $factura->fecha = Carbon::create($factura->fecha);
                    $pdf = PDF::loadView('compras.factura',compact('factura','detalles','perfil','tit'));
                    return $pdf->download('comprobante_NRO'.'_'.$factura->numero_factura.'.pdf');
                }
            }

        } else {

        /** SI ES USUARIO  BUSCA SU PERFIL Y EL DE SUS ADHERENTES */
        $perfiles = Perfil::where('user_id',Auth::user()->id)->get();
        $adherentes = Adherente::where('perfil_id',Auth::user()->documento)->get();
        $perfil = $perfiles->first();
        $tit = null;
        if($perfil->perfil_id === $factura->perfil_id){ /**SI LA FACTURA ES SUYA  CREA EL PDF Y DESCARGA LA FACTURA USANDO LA VISTA compras.factura */
            $factura->fecha = Carbon::create($factura->fecha);
            $pdf = PDF::loadView('compras.factura',compact('factura','detalles','perfil','tit'));
            return $pdf->download('comprobante_NRO'.'_'.$factura->numero_factura.'.pdf');
        }else{/**SI NO ES SU FACTURA BUSCA AL AHERENTE QUE REALIZO LA COMPRA Y CREA EL PDF Y DESCARGA LA FACTURA USANDO LA VISTA compras.factura */
            foreach ($adherentes as $ad){
                if($ad->dni == $factura->perfil_id){
                    $factura->fecha = Carbon::create($factura->fecha);
                    $perfil=$ad;
                    $tits = Perfil::where('perfil_id',Auth::user()->documento)->get();
                    $tit = $tits->first();
                    $pdf = PDF::loadView('compras.factura',compact('factura','detalles','perfil','tit'));
                    return $pdf->download('comprobante_NRO'.'_'.$factura->numero_factura.'.pdf');
                }

            }/**SI ES UN USUARIO Y NO ES EL DUEÑOD EL LA FACTURA O DE ALGUNO DE SUS ADHERENTES LOS ENVIA A LA VISTA(busqueda) */
            return redirect('busqueda');
        }
       }
       


    }

}
