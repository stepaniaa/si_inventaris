<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Perlengkapan extends Model
{
    protected $primaryKey = 'id_perlengkapan'; 
    protected $table = 'perlengkapan' ; 
    protected $fillable = [ 

        'id_perlengkapan',
        'kode_perlengkapan',
        'nama_perlengkapan',
        'stok_perlengkapan', 
        'harga_satuan_perlengkapan', 
        'tanggal_beli_perlengkapan', 
        'kondisi_perlengkapan', 
        'deskripsi_perlengkapan', 
        'foto_perlengkapan', 
        'id_ruang', 
        'id_kategori', 
    ];
    
    public function kategori() {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }
    
    public function ruang() {
        return $this->belongsTo(Ruang::class, 'id_ruang');
    }
}
