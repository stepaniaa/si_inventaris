<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PeminjamanPerlengkapan extends Model
{
    protected $table = 'peminjaman_perlengkapan';
    protected $primaryKey = 'id_peminjaman_perlengkapan';

    protected $fillable = [
        'id_peminjaman',
        'id_perlengkapan',
       // 'jumlah_dipinjam',
    ];

    public function peminjaman() {
        return $this->belongsTo(Peminjaman::class, 'id_peminjaman');
    }

    public function perlengkapan() {
        return $this->belongsTo(Perlengkapan::class, 'id_perlengkapan');
    }
}
