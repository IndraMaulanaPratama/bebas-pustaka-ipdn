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
        Schema::create('KONTEN_LITERASI', function (Blueprint $table) {
            $table->string('KONTEN_ID', 36)->primary()->comment('Primary Key untuk table konten literasi');
            $table->text('KONTEN_URL')->comment('URL menuju konten yang di upload oleh praja');
            $table->string('KONTEN_PRAJA', 8)->comment('Foreign Key ke data praja');
            $table->unsignedBigInteger('KONTEN_OFFICER');
            $table->enum('KONTEN_STATUS', ['Proses', 'Disetujui', 'Ditolak'])->default('Proses');
            $table->string('KONTEN_APPROVED')->nullable()->comment('Tanggal Approve');
            $table->text('KONTEN_NOTES')->nullable()->comment('Digunakan untuk memberikan keterangan saat pengajuan di tolak');
            $table->timestamps();
            $table->softDeletes();


            $table->foreign('KONTEN_OFFICER')->references('id')->on('users');
            $table->unsignedBigInteger('KONTEN_OFFICER', 255)->nullable()->change()->comment('Foreign Key ke table user sebagai petugas');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('KONTEN_LITERASI');
    }
};
