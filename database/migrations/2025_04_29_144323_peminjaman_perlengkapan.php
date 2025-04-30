<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PeminjamanPerlengkapan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('peminjaman_perlengkapan', function (Blueprint $table) {
            $table->bigIncrements('id_peminjaman_perlengkapan')->autoIncrement();

            // Informasi Staff Pengusul
            $table->unsignedBigInteger('id_peminjaman'); // Menyesuaikan dengan foreign key
            $table->unsignedBigInteger('id_perlengkapan'); // Menyesuaikan dengan foreign key
            $table->timestamps();
            $table->foreign('id_peminjaman')->references('id_peminjaman')->on('peminjaman')->onDelete('cascade');
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
