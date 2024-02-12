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
        Schema::create('visitors', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->foreignIdFor(\App\Models\Condo::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(\App\Models\Apartment::class)->constrained()->cascadeOnDelete();
            $table->string('rg')->nullable();
            $table->string('cpf', 14)->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->dateTime('entry_date');
            $table->dateTime('exit_date');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitors');
    }
};
