<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;


class SesiKapelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $idRuang = 1;  // Kapel A, misalnya

    // Peminjaman pertama (bentrok)
    $peminjaman1 = DB::table('peminjaman_kapel')->insertGetId([
        'nomor_induk' => '12345',
        'nama_peminjam' => 'John Doe',
        'kontak' => '082122334455',
        'email' => 'johndoe@example.com',
        'nama_kegiatan' => 'Kegiatan Agama 1',
        'id_ruang' => $idRuang,  // Kapel A
        'status_pengajuan' => 'disetujui',
        'rutin' => false,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
    ]);

    // Sesi untuk peminjaman pertama
    DB::table('sesi_kapel')->insert([
        'id_peminjaman_kapel' => $peminjaman1,
        'tanggal_mulai_sesi' => Carbon::parse('2025-06-01 08:00'),
        'tanggal_selesai_sesi' => Carbon::parse('2025-06-01 10:00'),
        'status_sesi' => 'aktif',
        'status_pengembalian_kp' => 'belum',
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
    ]);

    // Peminjaman kedua (berpotensi bentrok)
    $peminjaman2 = DB::table('peminjaman_kapel')->insertGetId([
        'nomor_induk' => '67890',
        'nama_peminjam' => 'Jane Smith',
        'kontak' => '082122334466',
        'email' => 'janesmith@example.com',
        'nama_kegiatan' => 'Kegiatan Agama 2',
        'id_ruang' => $idRuang,  // Kapel A
        'status_pengajuan' => 'disetujui',
        'rutin' => false,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
    ]);

    // Sesi untuk peminjaman kedua (berpotensi bentrok dengan sesi pertama)
    DB::table('sesi_kapel')->insert([
        'id_peminjaman_kapel' => $peminjaman2,
        'tanggal_mulai_sesi' => Carbon::parse('2025-06-01 09:00'),
        'tanggal_selesai_sesi' => Carbon::parse('2025-06-01 11:00'),
        'status_sesi' => 'aktif',
        'status_pengembalian_kp' => 'belum',
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
    ]);
    }
}


