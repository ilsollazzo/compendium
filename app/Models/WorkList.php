<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\WorkList
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\WorkListName> $work_list_names
 * @property-read int|null $work_list_names_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Work> $works
 * @property-read int|null $works_count
 * @method static \Illuminate\Database\Eloquent\Builder|WorkList newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WorkList newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WorkList query()
 * @mixin \Eloquent
 */
class WorkList extends Model
{
    protected $guarded = ['id'];

    public function works(): BelongsToMany
    {
        return $this->belongsToMany(Work::class, 'lnk_works_work_lists', 'work_list_id', 'work_id');
    }

    public function work_list_names(): HasMany
    {
        return $this->hasMany(WorkListName::class);
    }
}
