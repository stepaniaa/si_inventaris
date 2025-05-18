<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SesiKapel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('sesi_kapel', function (Blueprint $table) {
            $table->bigIncrements('id_sesi_kapel');
            $table->unsignedBigInteger('id_peminjaman_kapel');
            $table->datetime('tanggal_mulai_sesi')->nullable();
            $table->datetime('tanggal_selesai_sesi')->nullable();
            $table->enum('status_pengembalian_kp', ['belum', 'sudah', 'bermasalah'])->default('belum');
            $table->dateTime('tanggal_pengembalian_sesi_kp')->nullable();
            $table->string('catatan_kp')->nullable();
            $table->timestamps();

            $table->foreign('id_peminjaman_kapel')->references('id_peminjaman_kapel')->on('peminjaman_kapel')->onDelete('cascade');
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
