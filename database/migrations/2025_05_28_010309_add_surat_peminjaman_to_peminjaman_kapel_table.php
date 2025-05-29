<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSuratPeminjamanToPeminjamanKapelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('peminjaman_kapel', function (Blueprint $table) {
            $table->string('surat_peminjaman')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('peminjaman_kapel', function (Blueprint $table) {
            $table->dropColumn('surat_peminjaman');
        });
    }
}
