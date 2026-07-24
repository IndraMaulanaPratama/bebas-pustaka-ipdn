<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE SKRIPSI_FAKULTAS MODIFY COLUMN SKRIPSI_STATUS ENUM('Proses', 'Disetujui', 'Ditolak', 'Assign') DEFAULT 'Proses'");
        DB::statement("ALTER TABLE SKRIPSI_PERPUSTAKAAN MODIFY COLUMN SKRIPSI_STATUS ENUM('Proses', 'Disetujui', 'Ditolak', 'Assign') DEFAULT 'Proses'");
        DB::statement("ALTER TABLE SKRIPSI_SOFTCOPY MODIFY COLUMN SKRIPSI_STATUS ENUM('Proses', 'Disetujui', 'Ditolak', 'Assign') DEFAULT 'Proses'");
        DB::statement("ALTER TABLE KONTEN_LITERASI MODIFY COLUMN KONTEN_STATUS ENUM('Proses', 'Disetujui', 'Ditolak', 'Assign') DEFAULT 'Proses'");
        DB::statement("ALTER TABLE SURVEY MODIFY COLUMN SURVEY_STATUS ENUM('Proses', 'Disetujui', 'Ditolak', 'Assign') DEFAULT 'Proses'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE SKRIPSI_FAKULTAS MODIFY COLUMN SKRIPSI_STATUS ENUM('Proses', 'Disetujui', 'Ditolak') DEFAULT 'Proses'");
        DB::statement("ALTER TABLE SKRIPSI_PERPUSTAKAAN MODIFY COLUMN SKRIPSI_STATUS ENUM('Proses', 'Disetujui', 'Ditolak') DEFAULT 'Proses'");
        DB::statement("ALTER TABLE SKRIPSI_SOFTCOPY MODIFY COLUMN SKRIPSI_STATUS ENUM('Proses', 'Disetujui', 'Ditolak') DEFAULT 'Proses'");
        DB::statement("ALTER TABLE KONTEN_LITERASI MODIFY COLUMN KONTEN_STATUS ENUM('Proses', 'Disetujui', 'Ditolak') DEFAULT 'Proses'");
        DB::statement("ALTER TABLE SURVEY MODIFY COLUMN SURVEY_STATUS ENUM('Proses', 'Disetujui', 'Ditolak') DEFAULT 'Proses'");
    }
};
