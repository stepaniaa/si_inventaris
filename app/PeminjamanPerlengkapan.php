<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PeminjamanPerlengkapan extends Model
{
    protected $table = 'peminjaman_perlengkapam';
    protected $primaryKey = 'id_peminjaman_perlengkapan';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'nomor_induk_pk',
        'nama_peminjam_pk',
        'kontak_pk',
        'email_pk',
        'surat_peminjaman_pk',
        'jumlah_peminjaman_pk',
        'nama_kegiatan_pk',
        'keterangan_kegiatan_pk',
        'id_perlengkapan',
        'tanggal_mulai_pk',
        'tanggal_selesai_pk',
        'butuh_gladi_pk',
        'tanggal_gladi_pk',
        'tanggal_selesai_gladi_pk',
        'status_gladi_pk',
        'tanggal_pengembalian_gladi_pk',
        'butuh_livestream_pk',
        'butuh_operator_pk',
        'operator_sound_pk',
        'operator_live_pk',
        'status_pk',
        'tanggal_pengembalian_pk',
        'catatan_pengembalian_pk',
        'catatan_peminjaman_pk',
        'id_pj_peminjaman_pk',
        'id_pj_pengembalian_pk',
    ];
    
    public function perlengkapan()
    {
        return $this->belongsTo(Perlengkapan::class, 'id_perlengkapan', 'id_perlengkapan');
    }

    // Relasi ke user sebagai penanggung jawab peminjaman
    public function pjPeminjaman()
    {
        return $this->belongsTo(User::class, 'id_pj_peminjaman_pk');
    }

    // Relasi ke user sebagai penanggung jawab pengembalian
    public function pjPengembalian()
    {
        return $this->belongsTo(User::class, 'id_pj_pengembalian_pk');
    }
}
