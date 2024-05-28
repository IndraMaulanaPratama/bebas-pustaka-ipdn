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
        Schema::create('BEBAS_PUSTAKA', function (Blueprint $table) {
            $table->string('BEBAS_ID', 36)->primary()->comment('Primary Key untuk table bebas pustaka ');
            $table->string('BEBAS_NUMBER', 45)->nullable()->comment('Nomor surat similartias');
            $table->string('BEBAS_PRAJA', 8)->comment('Foreign Key ke data praja');
            $table->unsignedBigInteger('BEBAS_OFFICER');
            $table->timestamps();
            $table->softDeletes();
            $table->boolean('BEBAS_SIMILARITAS')->nullable()->default(false)->comment('Status Pengajuan Similaritas');
            $table->boolean('BEBAS_PINJAMAN_FAKULTAS')->nullable()->default(false)->comment('Status Pengajuan Pinjaman Fakultas');
            $table->boolean('BEBAS_PINJAMAN_PUSAT')->nullable()->default(false)->comment('Status Pengajuan Pinjaman Pusat');
            $table->boolean('BEBAS_DONASI_FAKULTAS')->nullable()->default(false)->comment('Status Pengajuan Donasi Fakultas');
            $table->boolean('BEBAS_DONASI_PUSAT')->nullable()->default(false)->comment('Status Pengajuan Donasu Pusat');
            $table->boolean('BEBAS_DONASI_POIN')->nullable()->default(false)->comment('Status Pengajuan Donasi Poin');
            $table->boolean('BEBAS_SURVEI')->nullable()->default(false)->comment('Status Pengajuan Survei Praja');
            $table->boolean('BEBAS_KONTEN_LITERASI')->nullable()->default(false)->comment('Status Pengajuan Konten Literasi');
            $table->boolean('BEBAS_REPOSITORY')->nullable()->default(false)->comment('Status Pengajuan Unggah Repository');
            $table->boolean('BEBAS_HARD_COPY_PUSAT')->nullable()->default(false)->comment('Status Pengajuan Pengumpulan Hard Copy Skripsi Perpustakaan Pusat');
            $table->boolean('BEBAS_HARD_COPY_FAKULTAS')->nullable()->default(false)->comment('Status Pengajuan Pengumpulan Hard Copy Skripsi Perpustakaan Fakultas');
            $table->boolean('BEBAS_SOFT_COPY')->nullable()->default(false)->comment('Status Pengajuan Pengumpulan Soft Copy');


            $table->foreign('BEBAS_OFFICER')->references('id')->on('users');
            $table->unsignedBigInteger('BEBAS_OFFICER', 255)->nullable()->change()->comment('Foreign Key ke table user sebagai petugas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('BEBAS_PUSTAKA');
    }
};
