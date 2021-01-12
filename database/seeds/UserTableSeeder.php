<?php

use Illuminate\Database\Seeder;

use App\Role;
use App\User;



class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_admin     = Role::where('name', 'admin')->first();
        $role_soporte = Role::where('name', 'soporte')->first();
        $role_usuario  = Role::where('name', 'usuario')->first();



		$user = new User();
        $user->name = 'Admin';
       
        $user->email = 'admin@example.com';
        $user->password = bcrypt('secret');
        $user->rol=1;
        $user->save();

        $user->roles()->attach($role_admin);



        $user = new User();
        $user->name = 'Soporte';
      
        $user->email = 'soporte@example.com';
        $user->password = bcrypt('secret');
        $user->rol=2;
        $user->save();
        
        $user->roles()->attach($role_soporte);
        

        

        $user = new User();
        $user->name = 'Usuario';
        
        $user->email = 'usuario@gmail.com';
        $user->password = bcrypt('secret');
        $user->rol=3;
        $user->save();
        
        $role_usuario  = Role::where('name', 'usuario')->first();
        $user->roles()->attach($role_usuario);
    }
}
