<?php

namespace App\Imports;

use App\Perfil;
use Maatwebsite\Excel\Concerns\ToModel;

class PerfilImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Perfil([
            'perfil_id' => $row[0],
            'nombre'    => $row[1],
        ]);
    }
}
