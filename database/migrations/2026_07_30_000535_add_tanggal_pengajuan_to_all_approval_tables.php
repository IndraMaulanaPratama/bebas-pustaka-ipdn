<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $tables = [
            ['DONASI_ELEKTRONIK', 'ELEKTRONIK_TANGGAL_PENGAJUAN', 'ELEKTRONIK_STATUS', 'ELEKTRONIK_APPROVED'],
            ['DONASI_FAKULTAS', 'FAKULTAS_TANGGAL_PENGAJUAN', 'FAKULTAS_STATUS', 'FAKULTAS_APPROVED'],
            ['DONASI_PUSTAKA', 'PUSTAKA_TANGGAL_PENGAJUAN', 'PUSTAKA_STATUS', 'PUSTAKA_APPROVED'],
            ['SKRIPSI_PERPUSTAKAAN', 'SKRIPSI_TANGGAL_PENGAJUAN', 'SKRIPSI_STATUS', 'SKRIPSI_APPROVED'],
            ['SKRIPSI_FAKULTAS', 'SKRIPSI_TANGGAL_PENGAJUAN', 'SKRIPSI_STATUS', 'SKRIPSI_APPROVED'],
            ['SKRIPSI_SOFTCOPY', 'SKRIPSI_TANGGAL_PENGAJUAN', 'SKRIPSI_STATUS', 'SKRIPSI_APPROVED'],
            ['PINJAMAN_PUSTAKA', 'PUSTAKA_TANGGAL_PENGAJUAN', 'PUSTAKA_STATUS', 'PUSTAKA_APPROVED'],
            ['PINJAMAN_FAKULTAS', 'FAKULTAS_TANGGAL_PENGAJUAN', 'FAKULTAS_STATUS', 'FAKULTAS_APPROVED'],
            ['REPOSITORY', 'REPOSITORY_TANGGAL_PENGAJUAN', 'REPOSITORY_STATUS', 'REPOSITORY_APPROVED'],
            ['BIMBINGAN_PEMUSTAKA', 'PEMUSTAKA_TANGGAL_PENGAJUAN', 'PEMUSTAKA_STATUS', 'PEMUSTAKA_APPROVED'],
            ['KONTEN_LITERASI', 'KONTEN_TANGGAL_PENGAJUAN', 'KONTEN_STATUS', 'KONTEN_APPROVED'],
        ];

        foreach ($tables as $t) {
            $tableName = $t[0];
            $colName = $t[1];
            $afterCol = $t[2];
            $approvedCol = $t[3];

            Schema::table($tableName, function (Blueprint $table) use ($colName, $afterCol) {
                $table->dateTime($colName)
                    ->nullable()
                    ->after($afterCol)
                    ->comment('Tanggal dan waktu pengajuan oleh praja');
            });

            DB::statement("UPDATE {$tableName} SET {$colName} = {$approvedCol} WHERE {$approvedCol} IS NOT NULL");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tables = [
            ['DONASI_ELEKTRONIK', 'ELEKTRONIK_TANGGAL_PENGAJUAN'],
            ['DONASI_FAKULTAS', 'FAKULTAS_TANGGAL_PENGAJUAN'],
            ['DONASI_PUSTAKA', 'PUSTAKA_TANGGAL_PENGAJUAN'],
            ['SKRIPSI_PERPUSTAKAAN', 'SKRIPSI_TANGGAL_PENGAJUAN'],
            ['SKRIPSI_FAKULTAS', 'SKRIPSI_TANGGAL_PENGAJUAN'],
            ['SKRIPSI_SOFTCOPY', 'SKRIPSI_TANGGAL_PENGAJUAN'],
            ['PINJAMAN_PUSTAKA', 'PUSTAKA_TANGGAL_PENGAJUAN'],
            ['PINJAMAN_FAKULTAS', 'FAKULTAS_TANGGAL_PENGAJUAN'],
            ['REPOSITORY', 'REPOSITORY_TANGGAL_PENGAJUAN'],
            ['BIMBINGAN_PEMUSTAKA', 'PEMUSTAKA_TANGGAL_PENGAJUAN'],
            ['KONTEN_LITERASI', 'KONTEN_TANGGAL_PENGAJUAN'],
        ];

        foreach ($tables as $t) {
            $tableName = $t[0];
            $colName = $t[1];

            Schema::table($tableName, function (Blueprint $table) use ($colName) {
                $table->dropColumn($colName);
            });
        }
    }
};
