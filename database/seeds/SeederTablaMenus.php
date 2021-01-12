<?php

use Illuminate\Database\Seeder;
use App\Menu;

class SeederTablaMenus extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
    	/*----- ADMINISTRADOR ----*/

        //Padres de Raiz	
	
		$m1 = factory(Menu::class)->create([
			'etiqueta' => 'Documentos',
			'pagina' => 'documento',
			'padre' => 0,
			'orden' => 1,
			'rol' => 1,
		]);

		
		
		$m3 = factory(Menu::class)->create([
			'etiqueta' => 'Tipos',
			'pagina' => 'tipo',
			'padre' => 0,
			'orden' => 2,
			'rol' => 1,
		]);
			
		$m4 = factory(Menu::class)->create([
			'etiqueta' => 'Usuarios',
			'pagina' => 'usuario',
			'padre' => 0,
			'orden' => 3,
			'rol' => 1,
		]);
		$m1 = factory(Menu::class)->create([
			'etiqueta' => 'Sector',
			'pagina' => 'sector',
			'padre' => 0,
			'orden' => 4,
			'rol' => 1,
		]);

		//--soporte
	
		
		$m1 = factory(Menu::class)->create([
			'etiqueta' => 'Documentos',
			'pagina' => 'documento',
			'padre' => 0,
			'orden' => 1,
			'rol' => 2,
		]);
		
		
		$m3 = factory(Menu::class)->create([
			'etiqueta' => 'Tipos',
			'pagina' => 'tipo',
			'padre' => 0,
			'orden' => 2,
			'rol' => 2,
		]);
	
		$m1 = factory(Menu::class)->create([
			'etiqueta' => 'Sector',
			'pagina' => 'sector',
			'padre' => 0,
			'orden' => 3,
			'rol' => 2,
		]);
		//--usuario
		
		
		$m1 = factory(Menu::class)->create([
			'etiqueta' => 'Documentos',
			'pagina' => 'documento',
			'padre' => 0,
			'orden' => 1,
			'rol' => 3,
		]);
		 
		
		
		

	

    }
}
