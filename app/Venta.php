<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $table='ventas';
    public $timestamps = false;
    protected $fillable = [
    
        'user_id',
        'Cliente',
        'Total_Neto_Renglón',
        'Cobertura','Tot_Cliente',
        'Obra_Social','Rubro',
        'T','Suc','Número',
        'Fecha',
        'Producto',
        'Cant',
        'Total_Bruto_Renglón',
        'Dto_Adic',
        'sucursal',
    ];
}
