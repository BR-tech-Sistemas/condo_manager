<?php

namespace App\Traits;

use App\Models\Condo;
use App\Models\Scopes\HasCondoScope;
use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasCondo
{

    /**
     * @return void
     */
    public static function bootHasCondo()
    {
        static::addGlobalScope(new HasCondoScope);
    }

    /**
     * @return BelongsTo
     */
    public function condo(): BelongsTo
    {
        return $this->belongsTo(Condo::class);
    }
}