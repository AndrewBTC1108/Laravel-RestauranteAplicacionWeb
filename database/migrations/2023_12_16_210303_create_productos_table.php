<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->double('precio'); //se usa para divisas
            $table->string('imagen');
            $table->boolean('disponible')->default(1);//1 es decir si va a estar disponible 0 no disponible
            $table->foreignId('categoria_id')->constrained()->onDelete('cascade');//foreing id a categorias
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
