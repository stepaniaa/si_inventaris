<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PeminjamanKapel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('peminjaman_kapel', function (Blueprint $table) {
            $table->bigIncrements('id_peminjaman_kapel')->autoIncrement();
            $table->string('nomor_induk');
            $table->string('nama_peminjam');
            $table->string('kontak');
            $table->string('asal_unit');
            $table->string('peran');
            $table->string('email');

            $table->boolean('butuh_livestream')->default(false);
            $table->boolean('butuh_operator')->default(false);
            $table->string('operator_sound')->nullable();
            $table->string('operator_live')->nullable();
            $table->string('nama_kegiatan');
            $table->text('keterangan_kegiatan')->nullable();
            $table->unsignedBigInteger('id_ruang');
            $table->boolean('rutin')->default(false);
            $table->enum('tipe_rutin', ['mingguan', 'bulanan'])->nullable();
            $table->integer('jumlah_perulangan')->nullable();
            $table->enum('status_pengajuan', ['proses', 'disetujui', 'ditolak'])->default('proses');

            $table->datetime('tanggal_pengembalian_1')->nullable();
            $table->string('catatan_pengembalian_1')->nullable();
            $table->unsignedBigInteger('id_pj_peminjaman')->nullable();
            $table->unsignedBigInteger('id_pj_pengembalian')->nullable();
            
            $table->timestamps();
            $table->foreign('id_pj_peminjaman')->references('id')->on('users')->onDelete('set null');
            $table->foreign('id_pj_pengembalian')->references('id')->on('users')->onDelete('set null');
            $table->foreign('id_ruang')->references('id_ruang')->on('ruang')->onDelete('cascade');
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
