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
        Schema::create('SETTING_APPS', function (Blueprint $table) {
            $table->string("SETTING_ID", 36)->primary()->comment('Primary Key untuk table setting aplikasi');
            $table->string("SETTING_HEAD_OFFICE_NAME", 255)->default('Indra Maulana Pratama S.T.')->comment('Nama Kepala Bagian yang menjabat');
            $table->string("SETTING_HEAD_OFFICE_ID", 50)->default('010101 01010101 010101')->comment('Nomor Induk kepala bagian');
            $table->text("SETTING_URL_SURVEY")->comment("URL untuk google form survey");
            $table->text("SETTING_URL_LITERASI")->comment("URL untuk google form literasi");
            $table->text("SETTING_URL_REPOSITORY")->comment("URL untuk google form repository");
            $table->unsignedBigInteger("SETTING_OFFICER");

            $table->timestamps();

            $table->foreign("SETTING_OFFICER")->references('id')->on('users');
            $table->unsignedBigInteger('SETTING_OFFICER', 255)->nullable()->change()->comment('Foreign Key ke table user sebagai petugas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('SETTING_APPS');
    }
};
