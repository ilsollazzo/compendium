<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Studio extends Model
{
    protected $guarded = ['id'];

    public function works(): BelongsToMany
    {
        return $this->belongsToMany(Work::class, 'lnk_works_studios', 'studio_id', 'work_id');
    }
}
