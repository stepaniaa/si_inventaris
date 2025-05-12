<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRutinToPeminjamanRuangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('peminjaman_ruang', function (Blueprint $table) {
            $table->enum('frekuensi', ['sekali', 'harian', 'mingguan', 'bulanan'])->default('sekali');
            $table->integer('interval')->nullable();
            $table->dateTime('tanggal_mulai_rutin')->nullable();
            $table->dateTime('tanggal_selesai_rutin')->nullable();
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
            $table->dropColumn('frekuensi');
            $table->dropColumn('interval');
            $table->dropColumn('tanggal_mulai_rutin');
            $table->dropColumn('tanggal_selesai_rutin');
        });
    }
}
