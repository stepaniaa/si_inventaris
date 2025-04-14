<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pengadaan extends Model
{
    protected $primaryKey = 'id_usulan_pengadaan'; 
    protected $table = 'pengadaan' ; 
    protected $fillable = [ 

        'id_usulan_pengadaan',
        'nama_perlengkapan_usulan', 
        'jumlah_usulan_pengadaan',
        'alasan_pengadaan', 
        'tanggal_usulan_pengadaan', 
        'tanggal_validasi_pengadaan',
        'catatan_pengadaan_kaunit', 
        'status_usulan_pengadaan', 
    ];
}
