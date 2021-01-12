<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', function () {
        
    return redirect('login');
});
 
Auth::routes(['verify' => true]);

  
    Route::get('busqueda',function(){
        return view('ventas.busqueda');            
    })->name('busqueda');
    
    Route::get('generate-comprobante/{id}','VentasController@ImprimirFactura')->name( 'comprobante');
    Route::get('generate-pdf','VentasController@generatePDF')->name( 'pdf');

    Route::resource('ventas','VentasController');
    Route::resource('sector','SectorController');
    Route::resource('tipo','TiposController');
    Route::resource('usuario','UsuariosController');
    Route::resource('adherente','AdherentesController');

    Route::get('/home', 'HomeController@index')->name('home');

    Route::get('/{slug}', 'HomeController@index');
