<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Announcement extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'show_dashboard',
        'priority',
        'condo_id',
        'valid_until',
    ];

    protected $casts = [
        'show_dashboard' => 'boolean',
        'valid_until' => 'date'
    ];

    public function condo(): BelongsTo
    {
        return $this->belongsTo(Condo::class);
    }
}
