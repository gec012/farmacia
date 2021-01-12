<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
    protected $table='perfil';
    public $timestamps = false;
    protected $fillable = [
    
        'perfil_id',
        'nombre',
        
    ];
}
