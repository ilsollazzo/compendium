<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\WorkListName
 *
 * @property-read \App\Models\Language $language
 * @property-read \App\Models\WorkList|null $work_list
 * @method static \Illuminate\Database\Eloquent\Builder|WorkListName newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WorkListName newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WorkListName query()
 * @mixin \Eloquent
 */
class WorkListName extends Model
{
    protected $guarded = ['id'];

    public function work_list(): BelongsTo
    {
        return $this->belongsTo(WorkList::class);
    }

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }
}
