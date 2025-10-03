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
        Schema::create('pet_observations', function (Blueprint $table) {
            $table->id();
            $table->text('description');

            $table->unsignedBigInteger('pet_id');
            $table->foreign('pet_id')->references('id')->on('pets');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pet_observations');
    }
};
