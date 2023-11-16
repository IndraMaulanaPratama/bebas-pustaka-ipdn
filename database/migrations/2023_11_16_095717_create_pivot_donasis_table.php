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
        Schema::create('PIVOT_DONASI', function (Blueprint $table) {
            $table->string("PIVOT_ID", 36)->primary()->comment("Primary Key untuk table pivot donasi");
            $table->string("PIVOT_PRAJA", 8)->comment("Foreign Key untuk data praja");
            $table->string("PIVOT_PUSTAKA", 36)->comment("Foreign Key untuk data donasi buku perpustakaan");
            $table->string("PIVOT_FAKULTAS", 36)->comment("Foreign Key untuk data donasi buku fakultas");
            $table->string("PIVOT_ELEKTRONIK", 36)->comment("Foreign Key untuk data donasi buku elektronik");
            $table->enum("PIVOT_STATUS", ["Selesai", "Belum Selesai"])->comment("Keterangan dari donasi, fakultas dan elektronik");
            $table->timestamps();
            $table->softDeletes();

            $table->foreign("PIVOT_PUSTAKA")->references("PUSTAKA_ID")->on("DONASI_PUSTAKA")->onDelete("cascade")->onUpdate("cascade");
            $table->foreign("PIVOT_FAKULTAS")->references("FAKULTAS_ID")->on("DONASI_FAKULTAS")->onDelete("cascade")->onUpdate("cascade");
            $table->foreign("PIVOT_ELEKTRONIK")->references("ELEKTRONIK_ID")->on("DONASI_ELEKTRONIK")->onDelete("cascade")->onUpdate("cascade");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('PIVOT_DONASI');
    }
};
