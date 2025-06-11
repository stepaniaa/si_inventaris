<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeminjamTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('peminjam', function (Blueprint $table) {
    $table->bigIncrements('id_peminjam')->autoIncrement();
    $table->string('name');
    $table->string('email')->unique();
    $table->string('status_user')->default('non-ukdw'); // ukdw atau non-ukdw
    $table->string('nim')->nullable(); // hanya UKDW
    $table->string('surat_bukti')->nullable(); // hanya non-UKDW
    $table->string('password');
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('peminjam');
    }
}
