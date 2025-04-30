<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Penghapusan extends Model
{
    protected $primaryKey = 'id_usulan_penghapusan';

    protected $table = 'penghapusan';

    protected $fillable = [
    'id_staff',
    'id_perlengkapan',
    'kode_perlengkapan', // Tambahkan ini
    'alasan_penghapusan',
    'tanggal_usulan_penghapusan',
    'id_kaunit',
    'tanggal_persetujuan_penghapusan',
    'catatan_penghapusan_kaunit',
    'status_usulan_penghapusan',
    'foto_penghapusan',
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