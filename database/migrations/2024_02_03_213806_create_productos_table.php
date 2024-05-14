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
            $table->string('codigo_producto', 150)->nullable();
            $table->string('descripcion', 250);
            $table->string('procedencia', 100)->nullable();
            $table->decimal('precio', 10, 2)->unsigned()->default(0);
            $table->integer('stock')->unsigned()->default(0);
            $table->string('codigo_barra', 10)->nullable();
            $table->string('image_path', 250)->nullable();
            $table->foreignId('marca_id')->nullable()->constrained('marcas')->onDelete('set null');
            $table->foreignId('categoria_id')->nullable()->constrained('categorias')->onDelete('set null');
            $table->tinyInteger('estado')->default(1);
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