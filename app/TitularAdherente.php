<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TitularAdherente extends Model
{

    protected $table='titulares_y_adherentes';
    public $timestamps = false;
    protected $fillable = [
    
       
  
    'titular_dni',           
    'dni',
    'nombre',
   'tipo_documento',
    'tipo_adherente',
    'convenio',
];
}
