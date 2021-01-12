<?php

namespace App\Imports;

use App\Venta;

use Maatwebsite\Excel\Concerns\ToModel;

use Illuminate\Support\Facades\Hash;

class VentasImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Venta([
            'user_id' => $row[0],
            'Cliente' => $row[1],
            'Fecha' => $row[2],
            'Producto' => $row[3],
            'Cant' => $row[4],
            'Total_Bruto_Renglón' => $row[5],
            'Dto_Adic' => $row[6],
            'Total_Neto_Renglón'  => $row[7],
            'Cobertura'   => $row[8], 
            'Tot_Cliente' => $row[9],
            'Obra_Social' => $row[10],
            'Rubro' => $row[11],
            'sucursal' =>$row[12], 
            'T' => $row[13],            
            'Suc' => $row[14],
            'Número' => $row[15],
        ]);
    }
}
