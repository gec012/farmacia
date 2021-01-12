<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    protected $table='facturas';
    public $timestamps = false;
    protected $fillable = [
    
        'perfil_id',
        'fecha',
        'numero_factura',
        'total_pagado',
        'sucursal',
       
    ];
}
