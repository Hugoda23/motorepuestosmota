<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('dias_disponibles', function (Blueprint $table) {
            $table->id();
            $table->date('fecha')->unique(); // Día único
            $table->time('hora_inicio'); // Hora de inicio de atención
            $table->time('hora_fin');    // Hora de finalización de atención
            $table->integer('limite_citas')->default(0); // 0 = sin límite
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dias_disponibles');
    }
};
