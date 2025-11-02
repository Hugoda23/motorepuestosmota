<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            $table->string('title');                 // Título de la promoción
            $table->string('subtitle')->nullable();  // Subtítulo o descripción corta
            $table->text('description')->nullable(); // Descripción larga
            $table->decimal('price', 10, 2)->nullable();
            $table->decimal('old_price', 10, 2)->nullable();
            $table->string('benefits')->nullable();  // Ejemplo: "Cambio de aceite gratis"
            $table->string('image')->nullable();
            $table->boolean('is_published')->default(false); // 🔹 Control de visibilidad
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('promotions');
    }
};
