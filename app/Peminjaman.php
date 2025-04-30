<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{

    protected $table = 'peminjaman';
    protected $primaryKey = 'id_peminjaman';

    protected $fillable = [
        'nomor_induk',
        'nama_peminjam',
        'email',
        'nomor_telpon',
        'status_peminjam',
        'asal_unit',
        'nama_kegiatan',
        'kegunaan_peminjaman',
        'tanggal_mulai',
        'tanggal_selesai',
        'pukul_mulai',
        'pukul_selesai',
        'surat_peminjaman',
        'status_peminjaman',
        'id_ruang',
        'waktu_pengembalian',
        'catatan_pengembalian',
        'pj_pengembalian',
    ];

    

    /**
     * Get the ruang that owns the Peminjaman
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ruang() {
        return $this->belongsTo(Ruang::class, 'id_ruang');
    }
}