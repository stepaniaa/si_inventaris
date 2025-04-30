<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Peminjaman extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->bigIncrements('id_peminjaman')->autoIncrement();
            
            //data peminjam
            $table->string('nomor_induk', 20);
            $table->string('nama_peminjam', 50);
            $table->string('email', 50)->nullable();
            $table->string('nomor_telpon', 20);
            $table->enum('status_peminjam', ['mahasiswa', 'dosen', 'staff']);
            $table->string('asal_unit',100);

            //detail kegiatan 
            $table->string('nama_kegiatan', 100);
            $table->string('kegunaan_peminjaman');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->time('pukul_mulai');
            $table->time('pukul_selesai');
            $table->string('surat_peminjaman', 255);
            $table->enum('status_peminjaman', ['diproses', 'diterima', 'ditolak', 'selesai'])->default('diproses');

            //peminjaman kapel 
            $table->unsignedBigInteger('id_ruang')->nullable(); // boleh nullable kalau dia ga pinjam ruang

            //pengembalian 
            $table->datetime('waktu_pengembalian')->nullable();
            $table->string('catatan_pengembalian',100)->nullable();
            $table->string('pj_pengembalian',50)->nullable();
            $table->timestamps();
            $table->foreign('id_ruang')->references('id_ruang')->on('ruang')->onDelete('set null');
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
