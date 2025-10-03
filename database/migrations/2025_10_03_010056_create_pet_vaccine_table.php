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
        Schema::create('pet_vaccine', function (Blueprint $table) {
            $table->id();
            $table->date('application_date');
            $table->date('due_date');

            $table->unsignedBigInteger('pet_id');
            $table->foreign('pet_id')->references('id')->on('pets');

            $table->unsignedBigInteger('vaccine_id');
            $table->foreign('vaccine_id')->references('id')->on('vaccines');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pet_vaccine');
    }
};
