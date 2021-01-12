<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Adherente extends Model
{
    protected $table='adherentes';
    public $timestamps = false;
    protected $fillable = [
    
        'perfil_id',     
        'dni',
        'nombre',
        'tipo_documento',
        'tipo_adherente',
        'convenio',
        
    ];
}
