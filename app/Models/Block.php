<?php

namespace App\Models;

use App\Traits\HasCondo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Block extends Model
{
    use HasCondo;

    protected $fillable = ['condo_id', 'title', 'has_sub_manager', 'has_parking_lot', 'has_apartments', 'infrastructure'];

    protected $casts = [
        'infrastructure' => 'array',
        'has_sub_manager' => 'boolean',
        'has_parking_lot' => 'boolean',
        'has_apartments' => 'boolean',
    ];

    /**
     * @return HasMany
     */
    public function apartments(): HasMany
    {
        return $this->hasMany(Apartment::class);
    }
}
