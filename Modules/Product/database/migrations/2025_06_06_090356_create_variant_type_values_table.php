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
        Schema::create('variant_type_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('variant_type_id')->constrained('variant_types');
            $table->string('value');
            $table->string('slug');
            $table->smallInteger('order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('variant_type_values');
    }
};
