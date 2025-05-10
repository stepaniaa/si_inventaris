<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PeminjamanPerlengkapanPerlengkapan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('peminjaman_perlengkapan_perlengkapan', function (Blueprint $table) {
            $table->bigIncrements('id_ppp')->autoIncrement();
            $table->unsignedBigInteger('peminjaman_pkp_id');
            $table->unsignedBigInteger('perlengkapan_id');
            $table->timestamps();

            $table->foreign('peminjaman_pkp_id')->references('id_peminjaman_perlengkapan')->on('peminjaman_perlengkapam')->onDelete('cascade');
            $table->foreign('perlengkapan_id')->references('id_perlengkapan')->on('perlengkapan')->onDelete('cascade');

            //$table->unique(['peminjaman_perlengkapam_id', 'perlengkapan_id']); // Mencegah duplikasi relasi.
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('peminjaman_perlengkapan_perlengkapan');
    }
}

