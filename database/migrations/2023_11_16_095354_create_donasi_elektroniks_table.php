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
        Schema::create('DONASI_ELEKTRONIK', function (Blueprint $table) {
            $table->string('ELEKTRONIK_ID', 36)->primary()->comment('Primary Key untuk table donasi buku elektronik');
            $table->string('ELEKTRONIK_ID_PO', 25)->comment('ID Purches Order dari pihak ke 3');
            $table->string('ELEKTRONIK_PRAJA', 8)->comment('Foreign Key ke data praja');
            $table->string('ELEKTRONIK_FAKULTAS', 3)->comment('Data fakultas praja');
            $table->unsignedBigInteger('ELEKTRONIK_OFFICER');
            $table->enum('ELEKTRONIK_STATUS', ['Proses', 'Disetujui', 'Ditolak'])->default('Proses');
            $table->string('ELEKTRONIK_APPROVED')->nullable()->comment('Tanggal Approve');
            $table->text('ELEKTRONIK_NOTES')->nullable()->comment('Digunakan untuk memberikan keterangan saat pengajuan di tolak');
            $table->timestamps();
            $table->softDeletes();


            $table->foreign('ELEKTRONIK_OFFICER')->references('id')->on('users');
            $table->unsignedBigInteger('ELEKTRONIK_OFFICER', 255)->nullable()->change()->comment('Foreign Key ke table user sebagai petugas');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('DONASI_ELEKTRONIK');
    }
};
