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
        Schema::create('feedbacks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('role')->nullable();
            $table->unsignedTinyInteger('rating')->default(5);
            $table->text('content');
            $table->string('image')->nullable();
            $table->json('photos')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index('is_featured');
            $table->index('sort_order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedbacks');
    }
};
