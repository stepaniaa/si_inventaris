<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Perbaikan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perbaikan', function (Blueprint $table) {
            $table->bigIncrements('id_usulan_perbaikan')->autoIncrement();

            // Informasi Staff Pengusul
            $table->unsignedBigInteger('id_staff'); // Menyesuaikan dengan foreign key
            $table->unsignedBigInteger('id_perlengkapan'); // Menyesuaikan dengan foreign key
            $table->string('alasan_perbaikan', 50);
            $table->decimal('estimasi_harga_perbaikan', 10, 2)->nullable();
            $table->dateTime('tanggal_usulan_perbaikan');
            $table->string('foto_perbaikan', 255);

            // Informasi Persetujuan Kepala Unit
            $table->unsignedBigInteger('id_kaunit')->nullable(); // Menyesuaikan dengan foreign key
            $table->dateTime('tanggal_persetujuan_perbaikan')->nullable();
            $table->text('catatan_perbaikan_kaunit')->nullable();
            $table->enum('status_usulan_perbaikan', ['diproses', 'diterima', 'ditolak'])->default('diproses');
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
