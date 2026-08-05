<?php

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * Service pusat pikeun nyatet sagala aktivitas nu lumangsung di aplikasi
 * (login/logout, tambah/ubah/hapus data, pengajuan, approve/reject,
 * cetak dokumen, export data, jrrd) supados tiasa ditembongkeun deui
 * di widget "Aktivitas Terbaru" dashboard sareng janten jejak audit.
 *
 * Cara maké:
 *   ActivityLogger::log('Pinjaman Pustaka', ActivityLogger::APPROVE,
 *       "Menyetujui pengajuan pinjaman pustaka a.n. {$nama}", $pinjaman);
 */
class ActivityLogger
{
    public const LOGIN = 'login';
    public const LOGOUT = 'logout';
    public const CREATE = 'create';
    public const SUBMIT = 'submit';
    public const UPDATE = 'update';
    public const DELETE = 'delete';
    public const APPROVE = 'approve';
    public const REJECT = 'reject';
    public const ASSIGN = 'assign';
    public const PRINT = 'print';
    public const EXPORT = 'export';
    public const RESUBMIT = 'resubmit';

    /**
     * Nyimpen hiji baris log aktivitas.
     *
     * Sengaja dibungkus try/catch supados upami aya kagagalan nyimpen log
     * (misalna tabel can di-migrate), fitur utama aplikasi teu kapangaruhan.
     *
     * @param string $module Nami modul, contona "Pinjaman Pustaka", "Role", "Menu"
     * @param string $action Salahsahiji konstanta di luhur (login, create, approve, jrrd)
     * @param string $description Kalimah nu bisa dibaca ku pangguna, contona "Menyetujui pengajuan ... a.n. ..."
     * @param Model|null $subject Data/record nu kapangaruhan (opsional)
     * @param array $properties Data tambihan pikeun kaperluan audit (opsional)
     */
    public static function log(
        string $module,
        string $action,
        string $description,
        ?Model $subject = null,
        array $properties = []
    ): ?ActivityLog {
        try {
            $user = Auth::user();
            $request = request();

            return ActivityLog::create([
                'user_id' => $user?->id,
                'user_name' => $user?->name,
                'user_role' => $user?->role?->ROLE_NAME,
                'module' => $module,
                'action' => $action,
                'description' => $description,
                'subject_type' => $subject ? $subject->getMorphClass() : null,
                'subject_id' => $subject?->getKey(),
                'properties' => $properties ?: null,
                'ip_address' => $request?->ip(),
                'user_agent' => $request?->userAgent(),
            ]);
        } catch (\Throwable $th) {
            logger()->error('ActivityLogger gagal nyimpen log: ' . $th->getMessage());
            return null;
        }
    }

    /**
     * Sarua sareng log(), tapi pikeun aktivitas nu acan aya user login
     * (contona percobaan login nu gagal). $userName dieusian manual.
     */
    public static function logAs(
        ?string $userName,
        string $module,
        string $action,
        string $description,
        array $properties = []
    ): ?ActivityLog {
        try {
            $request = request();

            return ActivityLog::create([
                'user_id' => null,
                'user_name' => $userName,
                'user_role' => null,
                'module' => $module,
                'action' => $action,
                'description' => $description,
                'properties' => $properties ?: null,
                'ip_address' => $request?->ip(),
                'user_agent' => $request?->userAgent(),
            ]);
        } catch (\Throwable $th) {
            logger()->error('ActivityLogger gagal nyimpen log: ' . $th->getMessage());
            return null;
        }
    }
}
