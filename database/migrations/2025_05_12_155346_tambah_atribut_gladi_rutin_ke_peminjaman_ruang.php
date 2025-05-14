<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TambahAtributGladiRutinKePeminjamanRuang extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    Schema::table('peminjaman_ruang', function (Blueprint $table) {
    $table->boolean('butuh_gladi_rutin')->default(false);
    $table->dateTime('tanggal_mulai_gladi_rutin')->nullable();
    $table->dateTime('tanggal_selesai_gladi_rutin')->nullable();
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
    $table->dropColumn('butuh_gladi_rutin');
    $table->dropColumn('tanggal_mulai_gladi_rutin');
    $table->dropColumn('tanggal_selesai_gladi_rutin');
});
    }
}
