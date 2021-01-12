<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleFactura extends Model
{
    protected $table='detalleFacturas';
    public $timestamps = false;
    protected $fillable = [
    
        'factura_id',
        'Total_Neto_Renglón',
        'Cobertura',
        'Tot_Cliente',
        'Obra_Social',
        'Rubro',
        'Producto',
        'Cant',
        'Total_Bruto_Renglón',
        'Dto_Adic',
    ];
}
