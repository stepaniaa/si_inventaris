<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusDanJsonToPeminjamanRuangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::table('peminjaman_ruang', function (Blueprint $table) {
            // Tambahkan kolom status_pengembalian jika belum ada
            if (!Schema::hasColumn('peminjaman_ruang', 'status_pengembalian')) {
                $table->enum('status_pengembalian', ['baik', 'terlambat', 'rusak', 'hilang', 'belum_dikembalikan'])->default('belum_dikembalikan')->after('tanggal_pengembalian');
            }

            // Tambahkan kolom jadwal_rutin_json jika belum ada
            if (!Schema::hasColumn('peminjaman_ruang', 'jadwal_rutin_json')) {
                $table->json('jadwal_rutin_json')->nullable()->after('rutin');
            }
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
            if (Schema::hasColumn('peminjaman_ruang', 'status_pengembalian')) {
                $table->dropColumn('status_pengembalian');
            }
            if (Schema::hasColumn('peminjaman_ruang', 'jadwal_rutin_json')) {
                $table->dropColumn('jadwal_rutin_json');
            }
        });
    }
}
