<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * App\Models\Author
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDescriptionAuthor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDescriptionAuthor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDescriptionAuthor query()
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDescriptionAuthor whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDescriptionAuthor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDescriptionAuthor whereName($value)
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Work> $works
 * @property-read int|null $works_count
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDescriptionAuthor whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDescriptionAuthor whereUpdatedAt($value)
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\WorkDescription> $work_descriptions
 * @property-read int|null $work_descriptions_count
 * @mixin \Eloquent
 */
class WorkDescriptionAuthor extends Model
{
    protected $guarded = ['id'];
    public function work_descriptions(): BelongsToMany
    {
        return $this->belongsToMany(WorkDescription::class, 'lnk_descriptions_authors');
    }
}
