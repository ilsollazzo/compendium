<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Work
 *
 * @property int $id
 * @property int $work_type_id
 * @property string $slug
 * @property int $year
 * @property int|null $duration
 * @property string|null $description
 * @property int $author_id
 * @property int $contains_episodes
 * @property int $is_description_ready
 * @property int $is_accessible
 * @property int $is_available
 * @property int $is_published
 * @property mixed $utils
 * @method static \Illuminate\Database\Eloquent\Builder|Work newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Work newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Work query()
 * @method static \Illuminate\Database\Eloquent\Builder|Work whereAuthorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Work whereContainsEpisodes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Work whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Work whereDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Work whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Work whereIsAccessible($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Work whereIsAvailable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Work whereIsDescriptionReady($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Work whereIsPublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Work whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Work whereUtils($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Work whereWorkTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Work whereYear($value)
 * @property-read \App\Models\WorkDescriptionAuthor $author
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ExternalReference> $external_references
 * @property-read int|null $external_references_count
 * @property-read \App\Models\WorkType $workType
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\WorkDescriptionAuthor> $description_authors
 * @property-read int|null $description_authors_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\WorkTitle> $titles
 * @property-read int|null $titles_count
 * @method static \Illuminate\Database\Eloquent\Builder|Work whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Work whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Work extends Model
{
    protected $guarded = ['id'];
    public function workType(): BelongsTo
    {
        return $this->belongsTo(WorkType::class);
    }

    public function titles(): HasMany
    {
        return $this->hasMany(WorkTitle::class);
    }

    public function descriptions(): HasMany
    {
        return $this->hasMany(WorkDescription::class);
    }

    public function external_references(): HasMany
    {
        return $this->hasMany(ExternalReference::class);
    }

    public function studios(): BelongsToMany
    {
        return $this->belongsToMany(Studio::class, 'lnk_works_studios');
    }
}
