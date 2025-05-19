<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusPerlengkapanToPerlengkapanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('perlengkapan', function (Blueprint $table) {
             $table->enum('status_perlengkapan', ['aktif', 'tidak aktif'])->default('aktif');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('perlengkapan', function (Blueprint $table) {
            //
        });
    }
}
