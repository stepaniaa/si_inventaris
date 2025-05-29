<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterFieldsNullableInPeminjamanKapel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('peminjaman_kapel', function (Blueprint $table) {
            //
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('peminjaman_kapel', function (Blueprint $table) {
            $table->boolean('butuh_livestream')->nullable()->change();
    $table->boolean('butuh_operator')->nullable()->change();
    $table->string('operator_sound')->nullable()->change();
    $table->string('operator_live')->nullable()->change();
        });
    }
}
