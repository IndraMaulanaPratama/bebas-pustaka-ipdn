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
        Schema::create('ACCESSES', function (Blueprint $table) {
            $table->string('ACCESS_ID', 36)->default(uuid_create(4))->primary();
            $table->string('ACCESS_NAME', 150)->nullable(true);
            $table->string('ACCESS_MENU', 36)->comment('FOREIGN KEY ke table pivot menu');
            $table->boolean('ACCESS_CREATE')->default(false);
            $table->boolean('ACCESS_READ')->default(false);
            $table->boolean('ACCESS_UPDATE')->default(false);
            $table->boolean('ACCESS_DELETE')->default(false);
            $table->boolean('ACCESS_RESTORE')->default(false);
            $table->boolean('ACCESS_DESTROY')->default(false);
            $table->boolean('ACCESS_DETAIL')->default(false);
            $table->boolean('ACCESS_VIEW')->default(false);

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('ACCESS_MENU')->references('PIVOT_ID')->on('PIVOT_MENU')->onUpdate('cascade')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ACCESSES');
    }
};
