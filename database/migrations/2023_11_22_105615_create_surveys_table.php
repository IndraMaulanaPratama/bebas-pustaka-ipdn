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
        Schema::create('SURVEY', function (Blueprint $table) {
            $table->string("SURVEY_ID", 36)->primary()->comment("Primary Key untuk table survey");
            $table->string('SURVEY_PRAJA', 8)->comment('Foreign Key ke data praja');
            $table->unsignedBigInteger('SURVEY_OFFICER');
            $table->enum('SURVEY_STATUS', ['Proses', 'Disetujui', 'Ditolak'])->default('Proses');
            $table->string('SURVEY_APPROVED')->nullable()->comment('Tanggal Approve');
            $table->text('SURVEY_NOTES')->nullable()->comment('Digunakan untuk memberikan keterangan saat pengajuan di tolak');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('SURVEY_OFFICER')->references('id')->on('users');
            $table->unsignedBigInteger('SURVEY_OFFICER', 255)->nullable()->change()->comment('Foreign Key ke table user sebagai petugas');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('SURVEY');
    }
};
