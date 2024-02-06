<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Language extends Model
{
    protected $guarded = ['id'];

    public function works(): HasMany
    {
        return $this->hasMany(Work::class);
    }

    public function descriptions(): HasMany
    {
        return $this->hasMany(WorkDescription::class);
    }
}
