<?php

namespace App\Models;

use App\Traits\HasCondo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CommonArea extends Model
{
    use HasCondo;
    protected $fillable = [
        'condo_id',
        'block_id',
        'title',
        'rentable',
        'schedulable',
        'need_authorization',
    ];

    protected $casts = [
        'rentable' => 'boolean',
        'schedulable' => 'boolean',
        'need_authorization' => 'boolean',
    ];

    public function block(): BelongsTo
    {
        return $this->belongsTo(Block::class);
    }
}
