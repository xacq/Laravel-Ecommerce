<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->integer('section_id');
            $table->integer('category_id');
            $table->integer('brand_id');
            $table->integer('vendor_id');
            $table->string('admin_tipo');
            $table->string('producto_nombre');
            $table->string('producto_codigo');
            $table->string('producto_color');
            $table->float('producto_precio');
            $table->integer('producto_descuento');
            $table->integer('producto_peso');
            $table->string('producto_image');
            $table->string('producto_video');
            $table->string('descripcion');
            $table->string('meta_titulo');
            $table->string('meta_descripcion');
            $table->string('meta_palabraclave');
            $table->enum('es_destacada',['No', 'Si']);
            $table->tinyInteger('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
