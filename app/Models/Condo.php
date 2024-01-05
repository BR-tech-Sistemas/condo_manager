<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Condo extends Model
{
    protected $fillable = ['name', 'cep', 'address', 'type'];

    public function residents()
    {
        return $this->belongsToMany(User::class);
    }
}
