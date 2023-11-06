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
        Schema::create('PIVOT_PINJAMAN', function (Blueprint $table) {
            $table->string("PIVOT_ID", 36)->primary()->comment("Primary Key untuk table pivot pinjaman");
            $table->string("PIVOT_PRAJA", 8)->comment("Foreign Key untuk data praja");
            $table->string("PIVOT_PUSTAKA", 36)->comment("Foreign Key untuk data bebas pinjaman perpustakaan");
            $table->string("PIVOT_FAKULTAS", 36)->comment("Foreign Key untuk data bebas pinjaman fakultas");
            $table->enum("PIVOT_STATUS", ["Selesai", "Belum Selesai"])->comment("Keterangan dari proses pustaka dan fakultas");
            $table->timestamps();
            $table->softDeletes();

            $table->foreign("PIVOT_PUSTAKA")->references("PUSTAKA_ID")->on("PINJAMAN_PUSTAKA")->onDelete("cascade")->onUpdate("cascade");
            $table->foreign("PIVOT_FAKULTAS")->references("FAKULTAS_ID")->on("PINJAMAN_FAKULTAS")->onDelete("cascade")->onUpdate("cascade");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('PIVOT_PINJAMAN');
    }
};
