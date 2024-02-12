<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Visitor extends Model
{
    protected $fillable = [
        'name',
        'condo_id',
        'apartment_id',
        'rg',
        'cpf',
        'phone',
        'email',
        'entry_date',
        'exit_date',
    ];

    protected $casts = [
        'entry_date' => 'datetime',
        'exit_date' => 'datetime',
    ];

    /**
     * @return BelongsTo
     */
    public function condo(): BelongsTo
    {
        return $this->belongsTo(Condo::class);
    }

    /**
     * @return BelongsTo
     */
    public function apartment(): BelongsTo
    {
        return $this->belongsTo(Apartment::class);
    }
}
