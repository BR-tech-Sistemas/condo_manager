<?php

use App\Models\Block;
use App\Models\Condo;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('common_areas', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Condo::class)->constrained('condos')->cascadeOnDelete();
            $table->foreignIdFor(Block::class)->nullable()->constrained('blocks')->nullOnDelete();
            $table->string('title');
            $table->boolean('rentable')->default(true);
            $table->boolean('schedulable')->default(true);
            $table->boolean('need_authorization')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('common_areas');
    }
};
