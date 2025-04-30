<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Perlengkapan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perlengkapan', function (Blueprint $table) {
            $table->bigIncrements('id_perlengkapan');
            $table->string('kode_perlengkapan', 10);
            $table->string('nama_perlengkapan', 50);
            $table->bigInteger('harga_satuan_perlengkapan');
	    $table->bigInteger('stok_perlengkapan');
            $table->date('tanggal_beli_perlengkapan'); // Menggunakan date untuk tanggal
            $table->string('kondisi_perlengkapan', 100);
            $table->text('deskripsi_perlengkapan'); // Menggunakan text untuk deskripsi panjang
            $table->string('foto_perlengkapan', 255);
            $table->unsignedBigInteger('id_ruang'); // Menyesuaikan dengan foreign key
            $table->unsignedBigInteger('id_kategori'); // Menyesuaikan dengan foreign key
            $table->timestamps();

            $table->foreign('id_ruang')->references('id_ruang')->on('ruang')->onDelete('cascade');
            $table->foreign('id_kategori')->references('id_kategori')->on('kategori')->onDelete('cascade');
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
