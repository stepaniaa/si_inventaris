<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class PeminjamanPkp extends Model
{
    
    protected $table = 'peminjaman_pkp'; // Nama tabel di database
    protected $primaryKey = 'id_peminjaman_pkp'; // Primary key tabel
    public $timestamps = true; // Apakah menggunakan timestamps (created_at, updated_at)

    protected $fillable = [
        'nomor_induk_pk',
        'nama_peminjam_pk',
        'kontak_pk',
        'email_pk',
        'nama_kegiatan_pk',
        'keterangan_kegiatan_pk',
        'tanggal_mulai_pk',
        'tanggal_selesai_pk',
        'butuh_gladi_pk',
        'tanggal_gladi_pk',
        'tanggal_selesai_gladi_pk',
        'butuh_livestream_pk',
        'butuh_operator_pk',
        'operator_sound_pk',
        'operator_live_pk',
        'surat_peminjaman_pk',
        'status_pk',
        'status_gladi_pk',
        //'id_user',
    ];

    public function perlengkapan(): BelongsToMany
    {
        return $this->belongsToMany(Perlengkapan::class, 'peminjaman_pkp_perlengkapan', 'id_peminjaman_pkp', 'id_perlengkapan')
                    ->withPivot(['jumlah_pk', 'kondisi_awal_pk', 'kondisi_akhir_pk']);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
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

