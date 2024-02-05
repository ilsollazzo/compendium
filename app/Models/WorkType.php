<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\WorkType
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|WorkType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WorkType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WorkType query()
 * @method static \Illuminate\Database\Eloquent\Builder|WorkType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkType whereUpdatedAt($value)
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Work> $works
 * @property-read int|null $works_count
 * @property string $slug
 * @method static \Illuminate\Database\Eloquent\Builder|WorkType whereSlug($value)
 * @mixin \Eloquent
 */
class WorkType extends Model
{
    protected $guarded = ['id'];
    public function works(): HasMany
    {
        return $this->hasMany(Work::class);
    }
}
