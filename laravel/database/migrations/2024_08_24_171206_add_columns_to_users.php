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
        Schema::table('users', function (Blueprint $table) {
            $table->string('direccion')->after('name');
            $table->string('ciudad')->after('direccion');
            $table->string('estado')->after('ciudad');
            $table->string('pais')->after('estado');
            $table->string('pincodigo')->after('pais');
            $table->string('celular')->after('pincodigo');
            $table->tinyInteger('status')->after('password');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('direccion');
            $table->dropColumn('ciudad');
            $table->dropColumn('estado');
            $table->dropColumn('pais');
            $table->dropColumn('pincodigo');
            $table->dropColumn('celular');
            $table->dropColumn('status');
        });
    }
};
