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
        Schema::create('location_histories', function (Blueprint $table) {
            $table->id();
            $table->decimal('latitude', 10,8);
            $table->decimal('longitude', 10, 8);

            $table->unsignedBigInteger('collar_id');
            $table->foreign('collar_id')->references('id')->on('collars');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('location_histories');
    }
};
