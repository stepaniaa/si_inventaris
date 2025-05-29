<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PeminjamanKapel extends Model
{
   protected $table = 'peminjaman_kapel';
    protected $primaryKey = 'id_peminjaman_kapel';

    protected $fillable = [
        'nomor_induk',
        'nama_peminjam',
        'kontak',
        'asal_unit',
        'peran',
        'email',
        'butuh_livestream',
        'butuh_operator',
        'operator_sound',
        'operator_live',
        'nama_kegiatan',
        'keterangan_kegiatan',
        'id_ruang',
        'rutin',
        'tipe_rutin',
        'jumlah_perulangan',
        'status_pengajuan',
        'tanggal_pengembalian_1',
        'catatan_pengembalian_1',
        'id_pj_peminjaman',
        'id_pj_pengembalian',
        'catatan_persetujuan_kapel',
        'tanggal_tervalidasi',
          'surat_peminjaman',
         'bukti_ukdw',
    ];

    public function ruang()
    {
        return $this->belongsTo(Ruang::class, 'id_ruang', 'id_ruang');
    }

    public function sesi()
    {
        return $this->hasMany(SesiKapel::class, 'id_peminjaman_kapel', 'id_peminjaman_kapel');
    }

    public function pjPeminjaman()
    {
        return $this->belongsTo(User::class, 'id_pj_peminjaman');
    }

    public function pjPengembalian()
    {
        return $this->belongsTo(User::class, 'id_pj_pengembalian');
    }
}
