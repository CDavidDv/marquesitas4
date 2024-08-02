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
        Schema::create('marquesita_ingrediente', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('marquesita_id');
            $table->unsignedBigInteger('ingrediente_id');
            $table->timestamps();
        
            $table->foreign('marquesita_id')->references('id')->on('marquesitas')->onDelete('cascade');
            $table->foreign('ingrediente_id')->references('id')->on('ingredientes')->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('marquesita_ingrediente');
    }
};
