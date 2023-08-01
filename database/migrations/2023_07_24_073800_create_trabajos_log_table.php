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
        Schema::create('trabajos_log', function (Blueprint $table) {
            $table->id();
            $table->integer("trabajador_id")->NULLABLE();
            $table->integer("trabajo_id")->NULLABLE();
            $table->dateTime("fecha_inicio")->NULLABLE();
            $table->dateTime("fecha_fin")->NULLABLE();
            $table->string('estado')->nullable();
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
        Schema::dropIfExists('trabajos_log');
    }
};
