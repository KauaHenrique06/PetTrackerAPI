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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['lost', 'founded', 'scanned', 'deceased']);
            $table->text("message");
            $table->foreignUuid('user_id')->constrained('users')->onDelete('cascade');
            $table->string("image_path")->nullable();
            $table->foreignId('pet_id')->constrained('pets')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
