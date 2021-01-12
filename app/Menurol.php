<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menurol extends Model
{
    protected $fillable = [
        'id','role_id', 'menu_id', 
    ];
 public function menuids()
    {    

        return Menurol::All();
        }

}
