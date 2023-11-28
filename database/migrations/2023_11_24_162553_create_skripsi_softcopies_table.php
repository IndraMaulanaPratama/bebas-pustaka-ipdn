<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('SKRIPSI_SOFTCOPY', function (Blueprint $table) {
            $table->string('SKRIPSI_ID', 36)->primary()->comment('Primary Key untuk table soft copy skripsi perpustakaan');
            $table->string('SKRIPSI_PRAJA', 8)->comment('Foreign Key ke data praja');
            $table->unsignedBigInteger('SKRIPSI_OFFICER');
            $table->enum('SKRIPSI_STATUS', ['Proses', 'Disetujui', 'Ditolak'])->default('Proses');
            $table->string('SKRIPSI_APPROVED')->nullable()->comment('Tanggal Approve');
            $table->text('SKRIPSI_NOTES')->nullable()->comment('Digunakan untuk memberikan keterangan saat pengajuan di tolak');
            $table->timestamps();
            $table->softDeletes();


            $table->foreign('SKRIPSI_OFFICER')->references('id')->on('users');
            $table->unsignedBigInteger('SKRIPSI_OFFICER', 255)->nullable()->change()->comment('Foreign Key ke table user sebagai petugas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('SKRIPSI_SOFTCOPY');
    }
};
