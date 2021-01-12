<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('user_id');
            $table->string('Fecha');
            $table->string('Cliente');
            $table->string('Producto');
            $table->string('Cant');
            $table->string('Total_Bruto_Renglón');
            $table->string('Dto_Adic');
            $table->string('Total_Neto_Renglón' );
            $table->string('Cobertura' ); 
            $table->string('Tot_Cliente'); 
            $table->string('Obra_Social');
            $table->string('Rubro'); 
            $table->string('sucursal');
            $table->string('T'); 
            $table->string('Suc'); 
            $table->string('Número'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ventas');
    }
}
