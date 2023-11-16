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
        Schema::create('DONASI_FAKULTAS', function (Blueprint $table) {
            $table->string('FAKULTAS_ID', 36)->primary()->comment('Primary Key untuk table donasi buku fakultas');
            $table->string('FAKULTAS_PRAJA', 8)->comment('Foreign Key ke data praja');
            $table->unsignedBigInteger('FAKULTAS_OFFICER');
            $table->enum('FAKULTAS_STATUS', ['Proses', 'Disetujui', 'Ditolak'])->default('Proses');
            $table->string('FAKULTAS_APPROVED')->nullable()->comment('Tanggal Approve');
            $table->text('FAKULTAS_NOTES')->nullable()->comment('Digunakan untuk memberikan keterangan saat pengajuan di tolak');
            $table->timestamps();
            $table->softDeletes();


            $table->foreign('FAKULTAS_OFFICER')->references('id')->on('users');
            $table->unsignedBigInteger('FAKULTAS_OFFICER', 255)->nullable()->change()->comment('Foreign Key ke table user sebagai petugas');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('DONASI_FAKULTAS');
    }
};
