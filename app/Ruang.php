<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ruang extends Model
{
    protected $primaryKey = 'id_ruang'; 
    protected $table = 'ruang' ; 
    protected $fillable = [ 

        'id_ruang',
        'kode_ruang',
        'nama_ruang', 
        'kapasitas_ruang', 
        'fasilitas_ruang', 
        'deskripsi_ruang', 
        'bisa_dipinjam', 
        'lokasi_ruang',
    ];
}
