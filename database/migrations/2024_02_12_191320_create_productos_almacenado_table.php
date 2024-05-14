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
        Schema::create('Productos_almacenados', function (Blueprint $table) {
            $table->id();
            $table->integer('stock')->unsigned();
            $table->decimal('precio', 10, 2)->unsigned();
            $table->foreignId('producto_id')->nullable()->constrained('Productos')->onDelete('set null');
            $table->foreignId('almacene_id')->nullable()->constrained('almacenes')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Productos_almacenados');
    }
};