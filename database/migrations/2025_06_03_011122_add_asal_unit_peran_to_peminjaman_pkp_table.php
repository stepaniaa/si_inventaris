<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAsalUnitPeranToPeminjamanPkpTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('peminjaman_pkp', function (Blueprint $table) {
        $table->string('asal_unit')->nullable();
        $table->string('peran')->nullable();
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
