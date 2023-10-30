<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('PRAJA', function (Blueprint $table) {
            $table->string('PRAJA_NPP', 8)->primary();
            $table->string('PRAJA_EMAIL', 150);
            $table->string('PRAJA_NOMOR_PONSEL', 14);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('PRAJA');
    }
};
