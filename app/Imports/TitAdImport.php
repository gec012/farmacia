<?php

namespace App\Imports;

use App\TitularAdherente;
use Maatwebsite\Excel\Concerns\ToModel;

class TitAdImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new TitularAdherente([
            
            'titular_dni' => $row[0],           
            'dni' => $row[2],
            'nombre' => $row[3],
            'tipo_documento'=> $row[4],
            'tipo_adherente'=> $row[5],
            'convenio' => $row[6],
           
        ]);
    }
}
