<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


use Illuminate\Foundation\Auth\User as Authenticatable;

class Peminjam extends Authenticatable
{
    protected $table = 'peminjam';
    protected $primaryKey = 'id_peminjam';

    protected $fillable = [
        'name', 'email', 'status_user', 'nim', 'surat_bukti', 'password', 'asal_unit', 'peran'
    ];

    protected $hidden = ['password'];
}