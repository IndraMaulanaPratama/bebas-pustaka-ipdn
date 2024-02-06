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
        Schema::create('DONASI_PUSTAKA', function (Blueprint $table) {
            $table->string('PUSTAKA_ID', 36)->primary()->comment('Primary Key untuk table donasi buku fakultas');
            $table->string('PUSTAKA_FAKULTAS', 3)->comment('Data fakultas praja');
            $table->string('PUSTAKA_PRAJA', 8)->comment('Foreign Key ke data praja');
            $table->unsignedBigInteger('PUSTAKA_OFFICER');
            $table->enum('PUSTAKA_STATUS', ['Proses', 'Disetujui', 'Ditolak'])->default('Proses');
            $table->string('PUSTAKA_APPROVED')->nullable()->comment('Tanggal Approve');
            $table->text('PUSTAKA_NOTES')->nullable()->comment('Digunakan untuk memberikan keterangan saat pengajuan di tolak');
            $table->timestamps();
            $table->softDeletes();


            $table->foreign('PUSTAKA_OFFICER')->references('id')->on('users');
            $table->unsignedBigInteger('PUSTAKA_OFFICER', 255)->nullable()->change()->comment('Foreign Key ke table user sebagai petugas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('DONASI_PUSTAKA');
    }
};
