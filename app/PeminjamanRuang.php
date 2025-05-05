<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PeminjamanRuang extends Model
{
    protected $table = 'peminjaman_ruang';
    protected $primaryKey = 'id_peminjaman_ruang';

    protected $fillable = [
        'nomor_induk',
        'nama_peminjam',
        'kontak',
        'email',
        'nama_kegiatan',
        'keterangan_kegiatan',
        'surat_peminjaman',
        'id_ruang',
        'tanggal_mulai',
        'tanggal_selesai',
        'jumlah_kursi_tetap',
        'jumlah_kursi_tambahan',
        'butuh_gladi',
        'tanggal_gladi',
        'status_gladi',
        'tanggal_pengembalian_gladi',
        'butuh_livestream',
        'butuh_operator',
        'operator_sound',
        'operator_live',
        'status',
        'tanggal_pengembalian',
        'catatan_pengembalian',
        'catatan_staff',
        'id_pj_peminjaman',
        'id_pj_pengembalian'
    ];

    public function ruang()
    {
        return $this->belongsTo(Ruang::class, 'id_ruang', 'id_ruang');
    }

    public function pjPeminjaman()
    {
        return $this->belongsTo(User::class, 'id_pj_peminjaman', 'id');
    }

    public function pjPengembalian()
    {
        return $this->belongsTo(User::class, 'id_pj_pengembalian', 'id');
    }
}