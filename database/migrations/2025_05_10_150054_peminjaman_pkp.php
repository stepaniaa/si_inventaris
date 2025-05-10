<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PeminjamanPkp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('peminjaman_pkp', function (Blueprint $table) {
            $table->bigIncrements('id_peminjaman_pkp')->autoIncrement();

            // Informasi peminjam
            $table->string('nomor_induk_pk');
            $table->string('nama_peminjam_pk');
            $table->string('kontak_pk');
            $table->string('email_pk');
            $table->string('surat_peminjaman_pk')->nullable();
            $table->integer('jumlah_peminjaman_pk')->nullable();

            // Informasi kegiatan
            $table->string('nama_kegiatan_pk');
            $table->string('keterangan_kegiatan_pk');
            //$table->unsignedBigInteger('id_perlengkapan');
            $table->datetime('tanggal_mulai_pk');
            $table->datetime('tanggal_selesai_pk');

            // Gladi
            $table->boolean('butuh_gladi_pk')->default(false);
            $table->datetime('tanggal_gladi_pk')->nullable();
            $table->datetime('tanggal_selesai_gladi_pk')->nullable();
            $table->enum('status_gladi_pk', ['tidak_ada_gladi', 'belum', 'selesai'])->default('tidak_ada_gladi')->nullable();
            $table->datetime('tanggal_pengembalian_gladi_pk')->nullable();

            // Live streaming & operator
            $table->boolean('butuh_livestream_pk')->default(false)->nullable();
            $table->boolean('butuh_operator_pk')->default(false)->nullable();
            $table->string('operator_sound_pk')->nullable();
            $table->string('operator_live_pk')->nullable();

            // Status dan pengembalian
            $table->enum('status_pk', ['diproses', 'disetujui', 'ditolak', 'selesai'])->default('diproses');
            $table->datetime('tanggal_pengembalian_pk')->nullable();
            $table->string('catatan_pengembalian_pk')->nullable();
            $table->string('catatan_peminjaman_pk')->nullable();

            $table->unsignedBigInteger('id_pj_peminjaman_pk')->nullable();
            $table->unsignedBigInteger('id_pj_pengembalian_pk')->nullable();
            

            $table->timestamps();

            // Relasi ke tabel ruang
           // $table->foreign('id_perlengkapan')->references('id_perlengkapan')->on('perlengkapan')->onDelete('cascade');
            $table->foreign('id_pj_peminjaman_pk')->references('id')->on('users')->onDelete('set null');
            $table->foreign('id_pj_pengembalian_pk')->references('id')->on('users')->onDelete('set null');
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
