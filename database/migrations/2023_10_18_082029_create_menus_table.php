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
        Schema::create('MENUS', function (Blueprint $table) {
            $table->string('MENU_ID', 36)->default(uuid_create(4))->primary();
            $table->string('MENU_NAME', 50);
            $table->string('MENU_ICON', 50)->default('bi-journal-a');
            $table->text('MENU_DESCRIPTION')->nullable(true)->comment('Keterangan menu');
            $table->string('MENU_URL', 20)->comment('Nama Route Dari Halaman');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('MENUS');
    }
};
