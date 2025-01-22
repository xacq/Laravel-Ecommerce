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
        Schema::create('vendors_business_details', function (Blueprint $table) {
            $table->id();
            $table->integer('vendor_id');
            $table->string('nombre_tienda');
            $table->string('direccion_tienda');
            $table->string('ciudad_tienda');
            $table->string('estado_tienda');
            $table->string('pais_tienda');
            $table->string('codigopin_tienda');
            $table->string('celular_tienda');
            $table->string('sitioweb_tienda');
            $table->string('email_tienda');
            $table->string('address_proof');
            $table->string('address_proof_image');
            $table->string('business_licencia_numero');
            $table->string('usd_moneda');
            $table->string('pan_number');
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
        Schema::dropIfExists('vendors_business_details');
    }
};
