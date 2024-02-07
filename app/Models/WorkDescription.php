<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * App\Models\WorkDescription
 *
 * @property int $id
 * @property int $work_id
 * @property int $language_id
 * @property string $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\WorkDescriptionAuthor> $authors
 * @property-read int|null $authors_count
 * @property-read \App\Models\Language $language
 * @property-read \App\Models\Work $work
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDescription newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDescription newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDescription query()
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDescription whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDescription whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDescription whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDescription whereLanguageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDescription whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDescription whereWorkId($value)
 * @mixin \Eloquent
 */
class WorkDescription extends Model
{
    protected $guarded = ['id'];

    public function work(): BelongsTo
    {
        return $this->belongsTo(Work::class);
    }

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }

    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(WorkDescriptionAuthor::class, 'lnk_descriptions_authors');
    }
}
