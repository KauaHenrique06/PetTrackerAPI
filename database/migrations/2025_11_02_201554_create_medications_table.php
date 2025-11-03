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
        Schema::create('pet_medications', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("type");
            $table->string("treatment_type");
            $table->string("dosage_form");
            $table->integer("dosing_interval")->nullable();
            $table->string("interval_unit")->nullable();
            $table->date("start_date");
            $table->date("end_date")->nullable();
            $table->string("description")->nullable();
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
        Schema::dropIfExists('medications');
    }
};
