<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SesiKapel extends Model
{
    protected $table = 'sesi_kapel';
    protected $primaryKey = 'id_sesi_kapel';

    protected $fillable = [
        'id_peminjaman_kapel',
        'tanggal_mulai_sesi',
        'tanggal_selesai_sesi',
        'status_pengembalian_kp',
        'tanggal_pengembalian_sesi_kp',
        'catatan_kp',
        'status_sesi', 
        'alasan_pembatalan',
    ];

    // Relasi ke peminjaman_kapel
    public function peminjaman()
    {
        return $this->belongsTo(PeminjamanKapel::class, 'id_peminjaman_kapel');
    }
}
