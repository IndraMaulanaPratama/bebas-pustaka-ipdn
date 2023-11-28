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
