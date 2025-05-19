<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropBeberapaKolomDariPeminjamanPkp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('peminjaman_pkp', function (Blueprint $table) {
            $table->dropColumn(['tanggal_mulai_pk', 'tanggal_selesai_pk', 'butuh_gladi_pk', 'tanggal_gladi_pk', 'tanggal_selesai_gladi_pk', 'status_gladi_pk', 'tanggal_pengembalian_gladi_pk']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('peminjaman_pkp', function (Blueprint $table) {
            //
        });
    }
}
