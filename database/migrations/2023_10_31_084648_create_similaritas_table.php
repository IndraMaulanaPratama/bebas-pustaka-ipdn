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
        Schema::create('SIMILARITAS', function (Blueprint $table) {
            $table->string('SIMILARITAS_ID', 36)->primary();
            $table->string('SIMILARITAS_NUMBER', 35)->nullable()->comment('Nomor surat similartias');
            $table->string('SIMILARITAS_PRAJA', 8)->comment('Foreign Key ke data praja');
            $table->string('SIMILARITAS_OFFICER', 255)->nullable()->comment('Foreign Key ke table user sebagai petugas');
            $table->text('SIMILARITAS_TITLE');
            $table->string('SIMILARITAS_CLASS', 255)->comment('Kelas di dalam turnitin');
            $table->string('SIMILARITAS_ABSENT', 4)->comment('No Absen didalam turnitin');
            $table->string('SIMILARITAS_VALUE', 2)->nullable()->comment('Tingkat persentase similaritas');
            $table->boolean('SIMILARITAS_BIBLIOGRAFI')->nullable()->comment('Berisi true dan false');
            $table->boolean('SIMILARITAS_SMALL_WORD')->nullable()->comment('Berisi true dan false');
            $table->string('SIMILARITAS_SMALL_WORD_COUNT')->nullable()->comment('Ketentuan small word yang diterapkan');
            $table->boolean('SIMILARITAS_QUOTE')->nullable()->comment('Berisi true dan false');
            $table->string('SIMILARITAS_APPROVED')->nullable()->comment('Tanggal Approve');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('SIMILARITAS_OFFICER')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('SIMILARITAS');
    }
};
