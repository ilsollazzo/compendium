<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\WorkList
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\WorkListDetail> $work_list_details
 * @property-read int|null $work_list_details_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Work> $works
 * @property-read int|null $works_count
 * @method static \Illuminate\Database\Eloquent\Builder|WorkList newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WorkList newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WorkList query()
 * @property int $id
 * @property string $slug
 * @property string|null $notes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|WorkList whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkList whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkList whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkList whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkList whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class WorkList extends Model
{
    protected $guarded = ['id'];

    public function works(): BelongsToMany
    {
        return $this->belongsToMany(Work::class, 'lnk_works_work_lists', 'work_list_id', 'work_id');
    }

    public function work_list_details(): HasMany
    {
        return $this->hasMany(WorkListDetail::class);
    }
}
