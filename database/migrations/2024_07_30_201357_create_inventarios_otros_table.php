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
        Schema::create('inventarios_otros', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('sucursal_id')->nullable();
            $table->unsignedInteger('items_id')->nullable();
            $table->decimal('cantidad',10,2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventarios_otros');
    }
};
