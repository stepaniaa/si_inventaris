<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SesiPeminjamanPkpTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    Schema::create('sesi_pkp', function (Blueprint $table) {
    $table->bigIncrements('id_sesi_pkp')->autoIncrement();
    $table->unsignedBigInteger('id_peminjaman_pkp');
    $table->date('tanggal_mulai_sesi')->nullable();
    $table->date('tanggal_selesai_sesi')->nullable();
    $table->enum('status_pengembalian', ['belum', 'sudah', 'bermasalah'])->default('belum');
    $table->dateTime('tanggal_pengembalian_sesi')->nullable();
    $table->timestamps();

    $table->foreign('id_peminjaman_pkp')->references('id_peminjaman_pkp')->on('peminjaman_pkp')->onDelete('cascade');
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
