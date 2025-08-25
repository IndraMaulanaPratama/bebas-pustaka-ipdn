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
        Schema::create('BIMBINGAN_PEMUSTAKA', function (Blueprint $table) {
            $table->string("PEMUSTAKA_ID", 36)->primary()->comment("Primary Key untuk table survey");
            $table->string('PEMUSTAKA_PRAJA', 8)->comment('Foreign Key ke data praja');
            $table->string('PEMUSTAKA_FAKULTAS', 3)->comment('Data fakultas praja');
            $table->unsignedBigInteger('PEMUSTAKA_OFFICER');
            $table->enum('PEMUSTAKA_STATUS', ['Proses', 'Disetujui', 'Ditolak', 'Assign'])->default('Proses');
            $table->string('PEMUSTAKA_APPROVED')->nullable()->comment('Tanggal Approve');
            $table->text('PEMUSTAKA_NOTES')->nullable()->comment('Digunakan untuk memberikan keterangan saat pengajuan di tolak');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('PEMUSTAKA_OFFICER')->references('id')->on('users');
            $table->unsignedBigInteger('PEMUSTAKA_OFFICER', 255)->nullable()->change()->comment('Foreign Key ke table user sebagai petugas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('BIMBINGAN_PEMUSTAKA');
    }
};
