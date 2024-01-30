<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Apartment extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = ['block_id', 'title', 'for_rent', 'for_sale', 'parking_lots'];

    /**
     * @var string[]
     */
    protected $casts = [
        'for_rent' => 'bool',
        'for_sale' => 'bool',
    ];

    /**
     * @return BelongsTo
     */
    public function block(): BelongsTo
    {
        return $this->belongsTo(Block::class);
    }

    /**
     * @return HasMany
     */
    public function residents(): HasMany
    {
        return $this->hasMany(ApartmentUser::class);
    }

    public function condos()
    {
        return $this->hasManyThrough(
            Condo::class,
            Block::class,
            'id',
            'id',
            'block_id',
            'condo_id',
        );
    }
}
