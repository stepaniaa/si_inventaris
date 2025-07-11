<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $primaryKey = 'id_kategori';
    protected $table = 'kategori' ; 
    protected $fillable = [ 

        'id_kategori',
        'nama_kategori',
    ];
     public function perlengkapan()
    {
        return $this->hasMany(Perlengkapan::class, 'id_kategori');
    }
    
}
