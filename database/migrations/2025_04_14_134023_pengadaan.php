<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Pengadaan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() //Belom relasi ke user 
    {
        Schema::create('pengadaan', function (Blueprint $table) {
            $table->bigIncrements('id_usulan_pengadaan')->autoIncrement();
            $table->string('nama_perlengkapan_usulan', 50);
            $table->integer('jumlah_usulan_pengadaan');
            $table->string('alasan_pengadaan', 50);
            $table->dateTime('tanggal_usulan_pengadaan');
            $table->dateTime('tanggal_validasi_pengadaan');
            $table->string('catatan_pengadaan_kaunit', 50);
            $table->enum('status_usulan_pengadaan', ['proses', 'diterima', 'ditolak']);
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
        //
    }
}
