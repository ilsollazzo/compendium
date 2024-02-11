<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\WorkEpisode
 *
 * @property int $id
 * @property int $work_id
 * @property int|null $number
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Work $work
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\WorkEpisodeTitle> $work_episode_titles
 * @property-read int|null $work_episode_titles_count
 * @method static \Illuminate\Database\Eloquent\Builder|WorkEpisode newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WorkEpisode newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WorkEpisode query()
 * @method static \Illuminate\Database\Eloquent\Builder|WorkEpisode whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkEpisode whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkEpisode whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkEpisode whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkEpisode whereWorkId($value)
 * @mixin \Eloquent
 */
class WorkEpisode extends Model
{
    protected $guarded = ['id'];

    public function work(): BelongsTo
    {
        return $this->belongsTo(Work::class);
    }

    public function work_episode_titles(): HasMany
    {
        return $this->hasMany(WorkEpisodeTitle::class);
    }
}
