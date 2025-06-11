<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdPeminjamToPeminjamanKapelAndPkpTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('peminjaman_kapel', function (Blueprint $table) {
            $table->unsignedBigInteger('id_peminjam')->after('id_peminjaman_kapel')->nullable();

            $table->foreign('id_peminjam')
                  ->references('id_peminjam')
                  ->on('peminjam')
                  ->onUpdate('cascade')
                  ->onDelete('set null');
        });

        // Tambahkan ke tabel peminjaman_pkp
        Schema::table('peminjaman_pkp', function (Blueprint $table) {
            $table->unsignedBigInteger('id_peminjam')->after('id_peminjaman_pkp')->nullable();

            $table->foreign('id_peminjam')
                  ->references('id_peminjam')
                  ->on('peminjam')
                  ->onUpdate('cascade')
                  ->onDelete('set null');
        });
    }
    

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('peminjaman_kapel_and_pkp_tables', function (Blueprint $table) {
            //
        });
    }
}
