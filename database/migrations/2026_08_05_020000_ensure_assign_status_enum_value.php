<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Daptar tabel + kolom status anu kudu mibanda nilai enum 'Assign'
     * (dipaké ku fitur "keepData"/petugas mimiti meriksa pengajuan).
     *
     * Migration ieu SENGAJA nyakup deui tabel-tabel anu (numutkeun file
     * migration-na) katingalina geus mibanda 'Assign' ti mimiti dijieun —
     * ieu pikeun jaga-jaga upami di server production, tabel kasebut
     * kadung di-migrate SAMEMEH nilai 'Assign' ditambihkeun kana file
     * migration aslina (parobahan dina file migration nu geus dijalankeun
     * moal kapangaruh ka database anu geus aya, kudu ngaliwatan migration
     * enggal siga ieu supados leres-leres katerapkeun).
     *
     * Nambihan nilai enum di tungtung daptar siga ieu aman keur data anu
     * geus aya (nilai lami teu dirobih/dihapus, ngan ditambihan hiji).
     */
    private array $columns = [
        'PINJAMAN_PUSTAKA' => 'PUSTAKA_STATUS',
        'PINJAMAN_FAKULTAS' => 'FAKULTAS_STATUS',
        'DONASI_PUSTAKA' => 'PUSTAKA_STATUS',
        'DONASI_FAKULTAS' => 'FAKULTAS_STATUS',
        'DONASI_ELEKTRONIK' => 'ELEKTRONIK_STATUS',
        'REPOSITORY' => 'REPOSITORY_STATUS',
        'SIMILARITAS' => 'SIMILARITAS_STATUS',
        'BIMBINGAN_PEMUSTAKA' => 'PEMUSTAKA_STATUS',
        'SKRIPSI_FAKULTAS' => 'SKRIPSI_STATUS',
        'SKRIPSI_PERPUSTAKAAN' => 'SKRIPSI_STATUS',
        'SKRIPSI_SOFTCOPY' => 'SKRIPSI_STATUS',
        'KONTEN_LITERASI' => 'KONTEN_STATUS',
        'SURVEY' => 'SURVEY_STATUS',
    ];

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        foreach ($this->columns as $table => $column) {
            DB::statement("ALTER TABLE {$table} MODIFY COLUMN {$column} ENUM('Proses', 'Disetujui', 'Ditolak', 'Assign') DEFAULT 'Proses'");
        }
    }

    /**
     * Reverse the migrations.
     *
     * Sengaja teu ngahapus deui nilai 'Assign' (down() dijieun kosong/no-op) —
     * fitur "keepData" merlukeun status ieu sangkan aya, jadi ngarollback
     * kana kaayaan tanpa 'Assign' bisa nyababkeun data anu geus aya (status
     * = 'Assign') teu valid deui.
     */
    public function down(): void
    {
        // Sengaja teu ngalakukeun nanaon.
    }
};
