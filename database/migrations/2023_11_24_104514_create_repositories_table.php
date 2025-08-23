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
        Schema::create('REPOSITORY', function (Blueprint $table) {
            $table->string('REPOSITORY_ID', 36)->primary()->comment('Primary Key untuk table repository');
            $table->text('REPOSITORY_URL')->comment('Url repository dari eprints');
            $table->string('REPOSITORY_PRAJA', 8)->comment('Foreign Key ke data praja');
            $table->string('REPOSITORY_FAKULTAS', 3)->comment('Data fakultas praja');
            $table->unsignedBigInteger('REPOSITORY_OFFICER');
            $table->enum('REPOSITORY_STATUS', ['Proses', 'Disetujui', 'Ditolak', 'Assign'])->default('Proses');
            $table->string('REPOSITORY_APPROVED')->nullable()->comment('Tanggal Approve');
            $table->text('REPOSITORY_NOTES')->nullable()->comment('Digunakan untuk memberikan keterangan saat pengajuan di tolak');
            $table->timestamps();
            $table->softDeletes();


            $table->foreign('REPOSITORY_OFFICER')->references('id')->on('users');
            $table->unsignedBigInteger('REPOSITORY_OFFICER', 255)->nullable()->change()->comment('Foreign Key ke table user sebagai petugas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('REPOSITORY');
    }
};
