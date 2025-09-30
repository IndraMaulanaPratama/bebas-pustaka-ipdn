<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class BebasPustaka extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "BEBAS_PUSTAKA";
    protected $primaryKey = "BEBAS_ID";
    protected $keyType = "string";
    protected $perPage = 10;
    protected $with = ['user'];
    protected $fillable = [
        'BEBAS_ID',
        'BEBAS_NUMBER',
        'BEBAS_PRAJA',
        'BEBAS_OFFICER',
        'BEBAS_SIMILARITAS',
        'BEBAS_PINJAMAN_FAKULTAS',
        'BEBAS_PINJAMAN_PUSAT',
        'BEBAS_DONASI_FAKULTAS',
        'BEBAS_DONASI_PUSAT',
        'BEBAS_DONASI_POIN',
        'BEBAS_SURVEI',
        'BEBAS_KONTEN_LITERASI',
        'BEBAS_REPOSITORY',
        'BEBAS_HARD_COPY_PUSAT',
        'BEBAS_HARD_COPY_FAKULTAS',
        'BEBAS_SOFT_COPY',
        'BEBAS_BIMBINGAN_PEMUSTAKA',
    ];

    // --- *** Ranahna Relasi *** --- //

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, "BEBAS_OFFICER", "id");
    }

    // --- *** Tungtung tina Ranahna Relasi *** --- //


    // --- *** Ranahna Sulap Kang rama *** --- //

    // Ngarobih nami field asli table
    public function scopeGeneralData($query)
    {
        return $query->select(
            'BEBAS_ID as id',
            'BEBAS_NUMBER as nomor_surat',
            'BEBAS_PRAJA as nomor_pokok_praja',
            'BEBAS_SIMILARITAS as status_similaritas',
            'BEBAS_PINJAMAN_FAKULTAS as status_pinjaman_perpustakaan_fakultas',
            'BEBAS_PINJAMAN_PUSAT as status_pinjaman_perpustakaan_pusat',
            'BEBAS_DONASI_FAKULTAS as status_donasi_perpustakaan_fakultas',
            'BEBAS_DONASI_PUSAT as status_donasi_perpustakaan_pusat',
            'BEBAS_DONASI_POIN as status_donasi_poin',
            'BEBAS_SURVEI as status_survei',
            'BEBAS_KONTEN_LITERASI as status_konten_literasi',
            'BEBAS_REPOSITORY as status_upload_repository',
            'BEBAS_HARD_COPY_PUSAT as status_hard_copy_perpustakaan_pusat',
            'BEBAS_HARD_COPY_FAKULTAS as status_hard_copy_perpustakaan_fakultas',
            'BEBAS_SOFT_COPY as status_soft_copy',
            'BEBAS_SOFT_COPY as status_bebas_pemustaka',
            'updated_at'
        );
    }


    // Milari data dumasar kana id
    public function scopeById($query, $id)
    {
        return $query->when($id, function ($query, $id) {
            return $query->where('BEBAS_ID', $id);
        });
    }

    // Milari data dumasar kana nomor pokok praja
    public function scopeByNpp($query, $npp)
    {
        return $query->when($npp, function ($query, $npp) {
            return $query->where('BEBAS_PRAJA', $npp);
        });
    }

    // Milari data dumasar kana angkatan
    public function scopeByAngkatan($query, $angkatan)
    {
        return $query->when($angkatan, function ($query, $angkatan) {
            return $query->where('BEBAS_PRAJA', 'LIKE', $angkatan . '%');
        });
    }

    // Milari data dumasar kana nomor surat
    public function scopeByNumber($query, $nomor)
    {
        return $query->when($nomor, function ($query, $nomor) {
            return $query->where('BEBAS_NUMBER', $nomor);
        });
    }

    // Milari data dumasar kana status
    public function scopeByStatus($query, $status)
    {
        return $query->when($status, function ($query, $status) {
            if ($status == 'proses') {
                return $query->where('BEBAS_NUMBER', null);
            } elseif ($status == 'selesai') {
                return $query->whereNotNull('BEBAS_NUMBER');
            }
        });
    }

    // --- *** Tungtung tina Ranahna Sulap Kang rama *** --- //
}
