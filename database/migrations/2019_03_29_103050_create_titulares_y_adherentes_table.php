<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTitularesYAdherentesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('titulares_y_adherentes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('titular_dni');           
            $table->string('dni');
            $table->string('nombre');
            $table->string('tipo_documento');
            $table->string('tipo_adherente')->nullable();
            $table->string('convenio');
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('titulares_y_adherentes');
    }
}
