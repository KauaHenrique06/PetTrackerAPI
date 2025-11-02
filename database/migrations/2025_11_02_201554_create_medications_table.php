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
            $table->string("dosage_form");
            $table->number("dosing_interval");
            $table->string("interval_unit");
            $table->date("start_date");
            $table->boolean("is_active");
            $table->date("end_date")->nullable();
            $table->string("description")->nullable();
            $table->date("due_date")->nullable();
            $table->foreign('pet_id')->references('id')->on('pets');
            $table->timestamps();
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
