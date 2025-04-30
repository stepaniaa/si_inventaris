<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Perbaikan extends Model
{
    protected $primaryKey = 'id_usulan_perbaikan';

    protected $table = 'perbaikan';

    protected $fillable = [
    'id_staff',
    'id_perlengkapan',
    'kode_perlengkapan', // Tambahkan ini
    'alasan_perbaikan',
    'estimasi_harga_perbaikan',
    'tanggal_usulan_perbaikan',
    'id_kaunit',
    'tanggal_persetujuan_perbaikan',
    'catatan_perbaikan_kaunit',
    'status_usulan_perbaikan',
    'foto_perbaikan',
    ];

    /**
     * Get the staff user that requested the repair.
     *
     * @return BelongsTo
     */
    public function staff(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_staff');
    }

    /**
     * Get the head of unit user that approved/rejected the repair.
     *
     * @return BelongsTo
     */
    public function kaunit(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_kaunit');
    }

    /**
     * Get the equipment that needs repair.
     *
     * @return BelongsTo
     */
    public function perlengkapan(): BelongsTo
    {
        return $this->belongsTo(Perlengkapan::class, 'id_perlengkapan', 'id_perlengkapan');
    }
}