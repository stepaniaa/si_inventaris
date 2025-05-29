<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusSesiAndAlasanDibatalkanToSesiPkpTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sesi_pkp', function (Blueprint $table) {
            $table->enum('status_sesi', ['aktif', 'batal'])->default('aktif');
            $table->string('alasan_dibatalkan')->nullable()->after('status_sesi');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sesi_pkp', function (Blueprint $table) {
            //
        });
    }
}
