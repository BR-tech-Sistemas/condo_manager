<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Block extends Model
{
    protected $fillable = ['condo_id', 'title', 'has_sub_manager', 'has_parking_lot', 'has_apartments', 'infrastructure'];

    protected $casts = [
        'infrastructure' => 'array',
        'has_sub_manager' => 'boolean',
        'has_parking_lot' => 'boolean',
        'has_apartments' => 'boolean',
    ];

    /**
     * @return BelongsTo
     */
    public function condo(): BelongsTo
    {
        return $this->belongsTo(Condo::class);
    }
}
