<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PeminjamanRuang extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('peminjaman_ruang', function (Blueprint $table) {
            $table->bigIncrements('id_peminjaman_ruang')->autoIncrement();

            // Informasi peminjam
            $table->string('nomor_induk');
            $table->string('nama_peminjam');
            $table->string('kontak');
            $table->string('email');
            $table->string('surat_peminjaman')->nullable();

            // Informasi kegiatan
            $table->string('nama_kegiatan');
            $table->string('keterangan_kegiatan');
            $table->unsignedBigInteger('id_ruang');
            $table->datetime('tanggal_mulai');
            $table->datetime('tanggal_selesai');
            $table->integer('jumlah_kursi_tetap')->default(0);
            $table->integer('jumlah_kursi_tambahan')->nullable(); // hanya diisi kalau minta tambahan

            // Gladi
            $table->boolean('butuh_gladi')->default(false);
            $table->datetime('tanggal_gladi')->nullable();
            $table->enum('status_gladi', ['tidak_ada_gladi', 'belum', 'selesai'])->default('tidak_ada_gladi');
            $table->datetime('tanggal_pengembalian_gladi')->nullable();

            // Live streaming & operator
            $table->boolean('butuh_livestream')->default(false);
            $table->boolean('butuh_operator')->default(false);
            $table->string('operator_sound')->nullable();
            $table->string('operator_live')->nullable();

            // Status dan pengembalian
            $table->enum('status', ['diproses', 'disetujui', 'ditolak', 'selesai'])->default('diproses');
            $table->datetime('tanggal_pengembalian')->nullable();
            $table->string('catatan_pengembalian')->nullable();

            $table->unsignedBigInteger('id_pj_peminjaman')->nullable();
            $table->unsignedBigInteger('id_pj_pengembalian')->nullable();
            

            $table->timestamps();

            // Relasi ke tabel ruang
            $table->foreign('id_ruang')->references('id_ruang')->on('ruang')->onDelete('cascade');
            $table->foreign('id_pj_peminjaman')->references('id')->on('users')->onDelete('set null');
            $table->foreign('id_pj_pengembalian')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('peminjaman_ruang');
    }
}


