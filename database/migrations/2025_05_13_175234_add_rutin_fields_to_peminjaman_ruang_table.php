<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRutinFieldsToPeminjamanRuangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('peminjaman_ruang', function (Blueprint $table) {
            $table->string('hari_rutin')->nullable(); // Hari untuk peminjaman rutin
            $table->time('waktu_mulai_rutin')->nullable(); // Waktu mulai rutin
            $table->time('waktu_selesai_rutin')->nullable(); // Waktu selesai rutin
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('peminjaman_ruang', function (Blueprint $table) {
            //
        });
    }
}
