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
        Schema::table('SIMILARITAS', function (Blueprint $table) {
            $table->dateTime('SIMILARITAS_TANGGAL_PENGAJUAN')
                ->nullable()
                ->after('SIMILARITAS_STATUS')
                ->comment('Tanggal dan waktu pengajuan oleh praja');
        });

        DB::statement("UPDATE SIMILARITAS SET SIMILARITAS_TANGGAL_PENGAJUAN = SIMILARITAS_APPROVED WHERE SIMILARITAS_APPROVED IS NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('SIMILARITAS', function (Blueprint $table) {
            $table->dropColumn('SIMILARITAS_TANGGAL_PENGAJUAN');
        });
    }
};
