<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Resume extends Model
{
    protected $guarded = [];

    public function experiences(): HasMany
    {
        return $this->hasMany(Experience::class);
    }
}
