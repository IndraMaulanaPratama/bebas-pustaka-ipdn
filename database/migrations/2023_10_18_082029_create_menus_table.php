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
        Schema::create('MENUS', function (Blueprint $table) {
            $table->id('MENU_ID');
            $table->string('MENU_NAME', 50);
            $table->text('MENU_DESCRIPTION')->comment('Keterangan menu');
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
