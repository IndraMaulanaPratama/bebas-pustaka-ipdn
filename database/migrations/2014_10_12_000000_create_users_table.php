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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            // $table->string('user_role', 36)->comment('Foreign key table role');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('nomor_ponsel', 15)->nullable();
            $table->string('photo', 255)->nullable();
            $table->string('sign', 255)->nullable();
            $table->rememberToken();
            $table->timestamps();

            $table->foreignUlid('user_role', 36)->references('ROLE_ID')->on('ROLES');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
