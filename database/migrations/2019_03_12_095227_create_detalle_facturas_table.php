<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetalleFacturasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalleFacturas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('factura_id')->unsigned()->nullable();
            $table->foreign('factura_id')->references('id')->on('facturas');
            $table->double('Total_Neto_Renglón');
            $table->double('Cobertura');
            $table->double('Tot_Cliente');
            $table->string('Obra_Social');
            $table->string('Rubro');
            $table->string('Producto');
            $table->integer('Cant');
            $table->double('Total_Bruto_Renglón');
            $table->double('Dto_Adic');
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detalleFacturas');
    }
}
