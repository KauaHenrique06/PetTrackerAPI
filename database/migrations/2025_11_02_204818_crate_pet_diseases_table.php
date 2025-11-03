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
        Schema::create('pet_diseases', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->boolean("is_chronic");
            $table->date("diagnosis_date");
            $table->date("resolved_date")->nullable();
            $table->date("diagnosis_status")->nullable();
            $table->string("clinical_notes")->nullable();
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
        //
    }
};
