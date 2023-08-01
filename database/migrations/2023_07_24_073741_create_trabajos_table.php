<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trabajos', function (Blueprint $table) {
            $table->id();
            $table->string("titulo")->NULLABLE();
            $table->string("descripcion")->NULLABLE();
            $table->integer("trabajador_id")->NULLABLE();
            $table->integer("parte_id")->NULLABLE();
            $table->dateTime("tiempo_estimado")->NULLABLE();
            $table->dateTime("tiempo_real")->NULLABLE();
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
        Schema::dropIfExists('trabajos');
    }
};
