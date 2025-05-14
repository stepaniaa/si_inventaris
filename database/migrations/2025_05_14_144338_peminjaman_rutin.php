<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PeminjamanRutin extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('peminjaman_rutin', function (Blueprint $table) {  // Tambahkan parameter $table
            $table->bigIncrements('id_peminjaman_rutin')->autoIncrement();
            $table->unsignedBigInteger('id_peminjaman_ruang');  // Menyimpan ID peminjaman ruang
            $table->foreign('id_peminjaman_ruang')->references('id_peminjaman_ruang')->on('peminjaman_ruang')->onDelete('cascade');  // Menetapkan foreign key ke tabel peminjaman_ruang
            $table->datetime('tanggal_rutin')->nullable();  // Menyimpan tanggal rutin yang terjadwal
            $table->datetime('tanggal_pengembalian_rutin')->nullable();  // Tanggal pengembalian rutin
            //$table->boolean('pengembalian')->nullable()->default(null);
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
