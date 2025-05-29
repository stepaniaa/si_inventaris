<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBisaDipinjamAndLokasiRuangToRuangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ruang', function (Blueprint $table) {
              $table->enum('bisa_dipinjam', ['ya', 'tidak'])->default('ya')->after('deskripsi_ruang');
              $table->string('lokasi_ruang')->nullable()->after('bisa_dipinjam');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ruang', function (Blueprint $table) {
            //
        });
    }
}
