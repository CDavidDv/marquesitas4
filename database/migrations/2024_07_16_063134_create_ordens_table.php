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
        Schema::create('ordens', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_comprador');
            $table->string('estado'); // pagado // entregado // cancelado
            $table->string('metodo');
            $table->decimal('total', 12, 2)->nullable();
            $table->decimal('pago', 12, 2)->nullable();
            $table->decimal('cambio', 12, 2)->nullable();
            $table->unsignedInteger('sucursal_id'); 
            $table->timestamps();
        });
        
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ordens');
    }
};
