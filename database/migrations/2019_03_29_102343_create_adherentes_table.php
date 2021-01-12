<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdherentesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adherentes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('perfil_id');
            $table->foreign('perfil_id')->references('perfil_id')->on('perfil');
            $table->integer('dni');
            $table->string('nombre');
            $table->string('tipo_documento');
            $table->string('tipo_adherente');
            $table->string('convenio');
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
        Schema::dropIfExists('adherentes');
    }
}
