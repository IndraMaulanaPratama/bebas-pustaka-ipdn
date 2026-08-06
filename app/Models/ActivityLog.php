<?php

namespace App\Models;

use App\Models\Traits\HasSmartDates;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ActivityLog extends Model
{
    use HasFactory;
    use HasSmartDates;
    use HasUuids;

    protected $table = 'activity_logs';
    protected $perPage = 10;

    protected $fillable = [
        'user_id',
        'user_name',
        'user_role',
        'module',
        'action',
        'description',
        'subject_type',
        'subject_id',
        'properties',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'properties' => 'array',
    ];

    /**
     * Daptar warna badge Bootstrap pikeun unggal jenis aktivitas,
     * dianggo di widget "Aktivitas Terbaru" dashboard.
     */
    public const ACTION_COLORS = [
        'login' => 'success',
        'logout' => 'secondary',
        'create' => 'primary',
        'submit' => 'primary',
        'update' => 'info',
        'delete' => 'danger',
        'approve' => 'success',
        'reject' => 'danger',
        'assign' => 'warning',
        'print' => 'warning',
        'export' => 'info',
        'resubmit' => 'primary',
    ];

    /**
     * Daptar icon Bootstrap Icons pikeun unggal jenis aktivitas.
     */
    public const ACTION_ICONS = [
        'login' => 'bi-box-arrow-in-right',
        'logout' => 'bi-box-arrow-left',
        'create' => 'bi-plus-circle-fill',
        'submit' => 'bi-plus-circle-fill',
        'update' => 'bi-pencil-fill',
        'delete' => 'bi-trash-fill',
        'approve' => 'bi-check2-all',
        'reject' => 'bi-dash-circle-fill',
        'assign' => 'bi-hourglass-split',
        'print' => 'bi-printer-fill',
        'export' => 'bi-file-earmark-arrow-down-fill',
        'resubmit' => 'bi-arrow-repeat',
    ];

    /**
     * Label Basa Indonesia nu babari dibaca pikeun unggal jenis aktivitas,
     * dianggo di halaman Riwayat Aktivitas (filter jeung kolom tabel).
     */
    public const ACTION_LABELS = [
        'login' => 'Login',
        'logout' => 'Logout',
        'create' => 'Tambah Data',
        'submit' => 'Ajukan Pengajuan',
        'update' => 'Ubah Data',
        'delete' => 'Hapus Data',
        'approve' => 'Setujui Pengajuan',
        'reject' => 'Tolak Pengajuan',
        'assign' => 'Mulai Periksa Pengajuan',
        'print' => 'Cetak Dokumen',
        'export' => 'Export Data',
        'resubmit' => 'Ajukan Ulang',
    ];

    // --- *** Ranahna Relasi *** --- //

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function subject(): MorphTo
    {
        return $this->morphTo(__FUNCTION__, 'subject_type', 'subject_id');
    }

    // --- *** Tungtung tina Ranahna Relasi *** --- //

    public function getActionColorAttribute(): string
    {
        return self::ACTION_COLORS[$this->action] ?? 'muted';
    }

    public function getActionIconAttribute(): string
    {
        return self::ACTION_ICONS[$this->action] ?? 'bi-circle-fill';
    }

    public function getActionLabelAttribute(): string
    {
        return self::ACTION_LABELS[$this->action] ?? ucfirst($this->action);
    }

    /**
     * Narjamahkeun string user_agent (nu asalna teknis pisan) jadi kalimah
     * anu babari dibaca ku jalma awam, contona "Google Chrome di Windows".
     * Sengaja ditulis manual (teu maké library tambihan) supados teu
     * nambihan dependency anyar ka proyek ieu.
     */
    public function getPerangkatLabelAttribute(): string
    {
        $ua = $this->user_agent;

        if (!$ua) {
            return 'Tidak diketahui';
        }

        $browser = match (true) {
            str_contains($ua, 'Edg/') => 'Microsoft Edge',
            str_contains($ua, 'OPR/') || str_contains($ua, 'Opera') => 'Opera',
            str_contains($ua, 'Chrome/') && !str_contains($ua, 'Chromium') => 'Google Chrome',
            str_contains($ua, 'CriOS/') => 'Google Chrome',
            str_contains($ua, 'FxiOS/') => 'Mozilla Firefox',
            str_contains($ua, 'Firefox/') => 'Mozilla Firefox',
            str_contains($ua, 'Safari/') && str_contains($ua, 'Version/') => 'Safari',
            default => 'Browser tidak dikenal',
        };

        $sistem = match (true) {
            str_contains($ua, 'Android') => 'Android',
            str_contains($ua, 'iPhone') || str_contains($ua, 'iPad') => 'iOS',
            str_contains($ua, 'Windows') => 'Windows',
            str_contains($ua, 'Mac OS X') || str_contains($ua, 'Macintosh') => 'macOS',
            str_contains($ua, 'Linux') => 'Linux',
            default => null,
        };

        return $sistem ? "{$browser} di {$sistem}" : $browser;
    }
}
