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
    public function up()
    {
        Schema::create('pengadaan', function (Blueprint $table) {
            $table->bigIncrements('id_usulan_pengadaan')->autoIncrement();

            // Informasi Staff Pengusul
            $table->unsignedBigInteger('id_staff'); // Menyesuaikan dengan foreign key
            $table->string('nama_perlengkapan_pengadaan', 50);
            $table->integer('jumlah_usulan_pengadaan');
            $table->string('alasan_pengadaan', 50);
            $table->decimal('estimasi_harga', 10, 2);
            $table->dateTime('tanggal_usulan_pengadaan');

            // Informasi Persetujuan Kepala Unit
            $table->unsignedBigInteger('id_kaunit')->nullable(); // Menyesuaikan dengan foreign key
            $table->dateTime('tanggal_persetujuan_kaunit')->nullable();
            $table->text('catatan_pengadaan_kaunit')->nullable();
            $table->enum('status_usulan_pengadaan', ['diproses', 'diterima', 'ditolak'])->default('diproses');
            $table->timestamps();
            $table->foreign('id_staff')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_kaunit')->references('id')->on('users')->onDelete('set null');
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
