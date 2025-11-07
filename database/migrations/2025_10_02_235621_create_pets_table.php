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
        Schema::create('pets', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->date('birthday');
            
            $table->foreignId('specie_id')->constrained('species')->onDelete('cascade');

            $table->string('color');

            $table->enum('sex', ['male', 'female']);

            $table->enum('size', ['small', 'medium', 'large']);

            $table->enum('status', ['safe', 'deceased', 'lost'])->default('safe');

            $table->string('breed', 100);

            $table->decimal('weight', 5, 2);

            $table->boolean('is_neutred');

            $table->string('image')->nullable();

            $table->uuid('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pets');
    }
};
