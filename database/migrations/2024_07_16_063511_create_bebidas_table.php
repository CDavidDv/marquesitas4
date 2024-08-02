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
        Schema::create('bebidas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('orden_id')->nullable();
            $table->string('nombre');
            $table->string('detalles')->nullable();
            $table->decimal('precio', 12, 2);
            $table->unsignedInteger('cantidad')->nullable();
            $table->timestamps();
            
            $table->foreign('orden_id')->references('id')->on('ordens')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bebidas');
    }
};
