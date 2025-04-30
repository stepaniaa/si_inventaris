<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pengadaan extends Model
{
    protected $primaryKey = 'id_usulan_pengadaan';
    protected $table = 'pengadaan';
    protected $fillable = [
        'id_staff',
        'nama_perlengkapan_pengadaan',
        'jumlah_usulan_pengadaan',
        'alasan_pengadaan',
        'estimasi_harga',
        'tanggal_usulan_pengadaan',
        'id_kaunit',
        'tanggal_persetujuan_kaunit',
        'catatan_pengadaan_kaunit',
        'status_usulan_pengadaan',
    ];

    public function staff()
    {
        return $this->belongsTo(User::class, 'id_staff', 'id');
    }
}