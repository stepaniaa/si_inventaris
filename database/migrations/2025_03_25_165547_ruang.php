<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Ruang extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ruang', function (Blueprint $table) {
            $table->bigIncrements('id_ruang')->autoIncrement();
            $table->string('kode_ruang', 20);
            $table->string('nama_ruang', 50);
            $table->string('kapasitas_ruang', 100);
            $table->string('fasilitas_ruang', 100);
            $table->string('deskripsi_ruang', 100);
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
