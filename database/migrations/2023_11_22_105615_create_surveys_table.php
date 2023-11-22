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
        Schema::create('SURVEY', function (Blueprint $table) {
            $table->string("SURVEY_ID", 36)->primary()->comment("Primary Key untuk table survey");
            $table->text("SURVEY_URL");
            $table->unsignedBigInteger('SURVEY_OFFICER');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('SURVEY_OFFICER')->references('id')->on('users');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('SURVEY');
    }
};
