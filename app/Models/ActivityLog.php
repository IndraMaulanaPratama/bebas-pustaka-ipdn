<?php

namespace App\Models;

use App\Models\Traits\HasSmartDates;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ActivityLog extends Model
{
    use HasFactory;
    use HasSmartDates;

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
}
