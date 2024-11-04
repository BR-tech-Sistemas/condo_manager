<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rule extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'file',
        'condo_id',
    ];

    protected $casts = [
        'condo_id' => 'integer'
    ];

    public function condo(): BelongsTo
    {
        return $this->belongsTo(Condo::class);
    }
}
