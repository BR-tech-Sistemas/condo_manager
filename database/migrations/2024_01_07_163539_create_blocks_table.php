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
        Schema::create('blocks', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Condo::class)->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->boolean('has_sub_manager')->default(false);
            $table->boolean('has_apartments')->default(true);
            $table->boolean('has_parking_lot')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blocks');
    }
};
