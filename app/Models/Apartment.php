<?php

namespace App\Models;

use App\Traits\HasCondo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Apartment extends Model
{
    use HasCondo;
    /**
     * @var string[]
     */
    protected $fillable = ['condo_id', 'block_id', 'title', 'for_rent', 'for_sale', 'parking_lots'];

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

    /**
     * @return HasMany
     */
    public function visitors(): HasMany
    {
        return $this->hasMany(Visitor::class);
    }
}
