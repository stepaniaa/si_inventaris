<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeminjamanPkpPerlengkapanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('peminjaman_pkp_perlengkapan', function (Blueprint $table) {
            $table->bigIncrements('id_pkp_perlengkapan')->autoIncrement(); // Laravel 6 menggunakan bigIncrements untuk primary key
            $table->unsignedBigInteger('id_peminjaman_pkp');
            $table->unsignedBigInteger('id_perlengkapan');
            $table->integer('jumlah_pk')->nullable(); // Kolom tambahan untuk jumlah
            $table->text('kondisi_awal_pk')->nullable();  // Kolom tambahan untuk kondisi awal
            $table->text('kondisi_akhir_pk')->nullable(); // Kolom tambahan untuk kondisi akhir
            $table->timestamps();

            $table->foreign('id_peminjaman_pkp')->references('id_peminjaman_pkp')->on('peminjaman_pkp')->onDelete('cascade');
            $table->foreign('id_perlengkapan')->references('id_perlengkapan')->on('perlengkapan')->onDelete('cascade');
            
            //Unique index untuk mencegah duplikas
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('peminjaman_pkp_perlengkapan');
    }
}
