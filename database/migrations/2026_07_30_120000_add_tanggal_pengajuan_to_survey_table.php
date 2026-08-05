<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('SURVEY', function (Blueprint $table) {
            $table->dateTime('SURVEY_TANGGAL_PENGAJUAN')
                ->nullable()
                ->after('SURVEY_STATUS')
                ->comment('Tanggal dan waktu pengajuan oleh praja');
        });

        DB::statement("UPDATE SURVEY SET SURVEY_TANGGAL_PENGAJUAN = SURVEY_APPROVED WHERE SURVEY_APPROVED IS NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('SURVEY', function (Blueprint $table) {
            $table->dropColumn('SURVEY_TANGGAL_PENGAJUAN');
        });
    }
};
