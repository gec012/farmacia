<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Alerta extends Model
{
    protected $table='alertas';

    protected $fillable = [
    
        'cantidad',
    ];

   
}
