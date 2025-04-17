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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->foreignId('category_id')->constrained('article_categories');
            $table->text('summary')->nullable();
            $table->string('image');
            $table->string('thumbnail')->nullable();
            $table->unsignedSmallInteger('read_time')->default(0);

            $table->string('alt')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_tags')->nullable();
            $table->string('meta_description')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
