<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PeminjamanRutin extends Model
{
     protected $table = 'peminjaman_rutin';

    protected $fillable = [
        'id_peminjaman_ruang', 'tanggal_rutin', 'tanggal_pengembalian_rutin', 'pengembalian'
    ];

    public function peminjamanRuang()
    {
        return $this->belongsTo(PeminjamanRuang::class, 'id_peminjaman_ruang');
    }

}
