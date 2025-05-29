<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBisaDipinjamPkToPerlengkapanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('perlengkapan', function (Blueprint $table) {
            $table->enum('bisa_dipinjam_pk', ['ya', 'tidak'])->default('ya');
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
            
        });
    }
}
