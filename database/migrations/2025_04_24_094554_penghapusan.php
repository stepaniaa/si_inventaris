<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Penghapusan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penghapusan', function (Blueprint $table) {
            $table->bigIncrements('id_usulan_penghapusan')->autoIncrement();

            // Informasi Staff Pengusul
            $table->unsignedBigInteger('id_staff'); // Menyesuaikan dengan foreign key
            $table->unsignedBigInteger('id_perlengkapan'); // Menyesuaikan dengan foreign key
            $table->string('alasan_penghapusan', 50);
            $table->dateTime('tanggal_usulan_penghapusan');
            $table->string('foto_penghapusan', 255);

            // Informasi Persetujuan Kepala Unit
            $table->unsignedBigInteger('id_kaunit')->nullable(); // Menyesuaikan dengan foreign key
            $table->dateTime('tanggal_persetujuan_penghapusan')->nullable();
            $table->text('catatan_penghapusan_kaunit')->nullable();
            $table->enum('status_usulan_penghapusan', ['diproses', 'diterima', 'ditolak'])->default('diproses');
            $table->timestamps();
            $table->foreign('id_staff')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_kaunit')->references('id')->on('users')->onDelete('set null');
            $table->foreign('id_perlengkapan')->references('id_perlengkapan')->on('perlengkapan')->onDelete('cascade');
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
