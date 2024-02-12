<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Condo extends Model
{
    protected $fillable = ['name', 'cep', 'address', 'type'];

    public function residents()
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * @return HasMany
     */
    public function blocks(): HasMany
    {
        return $this->hasMany(Block::class);
    }

    /**
     * @return HasMany
     */
    public function apartments(): HasMany
    {
        return $this->hasMany(Apartment::class);
    }


    /**
     * @return HasMany
     */
    public function visitors(): HasMany
    {
        return $this->hasMany(Visitor::class);
    }
}
