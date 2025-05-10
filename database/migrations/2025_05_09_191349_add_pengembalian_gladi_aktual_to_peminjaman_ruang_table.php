<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPengembalianGladiAktualToPeminjamanRuangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('peminjaman_ruang', function (Blueprint $table) {
            $table->datetime('pengembalian_gladi_aktual')->nullable()->after('tanggal_pengembalian_gladi');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('peminjaman_ruang', function (Blueprint $table) {
            $table->dropColumn('pengembalian_gladi_aktual');
        });
    }
}
