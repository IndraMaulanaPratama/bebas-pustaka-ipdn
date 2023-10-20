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
        Schema::create('PIVOT_MENU', function (Blueprint $table) {
            $table->string('PIVOT_ID', 36)->default(uuid_create(4))->primary()->comment('Isi default menggunakan uuid v4');
            $table->string('PIVOT_MENU', 36)->comment('FOREIGN KEY ke table menu');
            $table->string('PIVOT_ROLE', 36)->comment('FOREIGN KEY ke table role');
            $table->text('PIVOT_DESCRIPTION')->nullable()->comment('Katerangan tinu maksad didamelna menu kanggo role anu di maksad');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('PIVOT_MENU')->references('MENU_ID')->on('MENUS')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('PIVOT_ROLE')->references('ROLE_ID')->on('ROLES')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('PIVOT_MENU');
    }
};
