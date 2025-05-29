<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBagianEnumToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
        $table->enum('bagian', [
            'staff_administrasi_umum',
            'staff_keuangan_dan_pengadaan',
            'staff_psikolog',
            'staff_konselor',
            'staff_spiritualitas',
            'staff_kreatif_ministry',
            //'kepala_unit',
        ])->nullable(); // sesuaikan posisi kolom
    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
