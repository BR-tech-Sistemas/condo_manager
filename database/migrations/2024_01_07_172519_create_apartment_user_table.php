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
        Schema::create('apartment_user', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Apartment::class)->constrained()->noActionOnDelete()->noActionOnDelete();
            $table->foreignIdFor(\App\Models\User::class)->nullable()->constrained()->nullOnDelete()->noActionOnUpdate();
            $table->boolean('is_owner')->default(true);
            $table->boolean('is_tenant')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apartment_user');
    }
};
