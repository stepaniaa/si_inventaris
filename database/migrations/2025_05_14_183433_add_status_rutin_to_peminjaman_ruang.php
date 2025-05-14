<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusRutinToPeminjamanRuang extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('peminjaman_ruang', function (Blueprint $table) {
            $table->enum('status_rutin', ['aktif', 'selesai', 'masalah'])->nullable()->default('aktif');
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
