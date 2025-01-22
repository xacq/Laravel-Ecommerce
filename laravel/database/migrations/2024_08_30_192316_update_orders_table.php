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
        Schema::table('orders',function($table){
            $table->string('nombre_mensajero')->after('total_general');
            $table->string('numero_rastreo')->after('nombre_mensajero');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders',function($table){
            $table->dropColumn('nombre_mensajero');
            $table->dropColumn('numero_rastreo');

        });
    }
};
