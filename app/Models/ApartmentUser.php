<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ApartmentUser extends Pivot
{
    protected $fillable = ['apartment_id', 'user_id', 'is_owner', 'is_tenant'];

    protected $casts = [
        'is_owner' => 'bool',
        'is_tenant' => 'bool',
    ];

    /**
     * @return BelongsTo
     */
    public function apartment(): BelongsTo
    {
        return $this->belongsTo(Apartment::class);
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
