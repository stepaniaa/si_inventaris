<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SesiPkp extends Model
{
    protected $table = 'sesi_pkp';
    protected $primaryKey = 'id_sesi_pkp';

    protected $fillable = [
        'id_peminjaman_pkp',
        'tanggal_mulai_sesi',
        'tanggal_selesai_sesi',
        'status_pengembalian',
        'tanggal_pengembalian_sesi',
        'catatan',
    ];

    public function peminjaman()
    {
        return $this->belongsTo(PeminjamanPkp::class, 'id_peminjaman_pkp');
    }
}
