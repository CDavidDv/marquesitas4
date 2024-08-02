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
        Schema::create('bebidas_inventarios', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('detalles')->nullable();
            $table->decimal('precio', 12, 2);
            $table->unsignedInteger('cantidad')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bebidas_inventarios');
    }
};
