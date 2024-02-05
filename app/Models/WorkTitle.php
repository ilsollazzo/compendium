<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Title
 *
 * @property-read \App\Models\Work $work
 * @method static \Illuminate\Database\Eloquent\Builder|WorkTitle newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WorkTitle newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WorkTitle query()
 * @mixin \Eloquent
 */
class WorkTitle extends Model
{
    protected $guarded = ['id'];
    public function work(): BelongsTo
    {
        return $this->belongsTo(Work::class);
    }
}
