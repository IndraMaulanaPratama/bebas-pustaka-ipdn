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
        Schema::create('PIVOT_SKRIPSI', function (Blueprint $table) {
            $table->string("PIVOT_ID", 36)->primary()->comment("Primary Key untuk table pivot skripsi");
            $table->string("PIVOT_PRAJA", 8)->comment("Foreign Key untuk data praja");
            $table->string("PIVOT_PUSTAKA", 36)->comment("Foreign Key untuk data skripsi perpustakaan");
            $table->string("PIVOT_FAKULTAS", 36)->comment("Foreign Key untuk data skripsi fakultas");
            $table->string("PIVOT_SOFTCOPY", 36)->comment("Foreign Key untuk data skripsi elektronik");
            $table->timestamps();
            $table->softDeletes();

            $table->foreign("PIVOT_PUSTAKA")->references("SKRIPSI_ID")->on("SKRIPSI_PERPUSTAKAAN")->onDelete("cascade")->onUpdate("cascade");
            $table->foreign("PIVOT_FAKULTAS")->references("SKRIPSI_ID")->on("SKRIPSI_FAKULTAS")->onDelete("cascade")->onUpdate("cascade");
            $table->foreign("PIVOT_SOFTCOPY")->references("SKRIPSI_ID")->on("SKRIPSI_SOFTCOPY")->onDelete("cascade")->onUpdate("cascade");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('PIVOT_SKRIPSI');
    }
};
