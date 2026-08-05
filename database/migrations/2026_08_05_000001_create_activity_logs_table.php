<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * Table pikeun nyimpen sagala rupa aktivitas nu lumangsung di aplikasi
     * (login, tambah/ubah/hapus data, pengajuan, approve/reject, cetak, export, dll)
     * pikeun ditembongkeun deui di widget "Aktivitas Terbaru" dashboard.
     */
    public function up(): void
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();

            // Sasaha nu ngalakukeun aktivitas (disimpen duplikat name/role
            // supados riwayat tetep kabaca sanajan data user robih/dihapus)
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('user_name')->nullable();
            $table->string('user_role')->nullable();

            // Modul jeung jenis aktivitas, contona modul "Pinjaman Pustaka", action "approve"
            $table->string('module');
            $table->string('action');
            $table->text('description');

            // Data/record nu kapangaruhan ku aktivitas ieu (polymorphic reference)
            $table->string('subject_type')->nullable();
            $table->string('subject_id')->nullable();
            $table->json('properties')->nullable();

            // Jejak teknis kanggo kaperluan audit
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent')->nullable();

            $table->timestamps();

            $table->index('module');
            $table->index('action');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
