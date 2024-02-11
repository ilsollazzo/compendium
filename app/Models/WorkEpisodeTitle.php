<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\WorkEpisodeTitle
 *
 * @property int $id
 * @property int $work_episode_id
 * @property int $language_id
 * @property string $title
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Language $language
 * @property-read \App\Models\WorkEpisode $work_episode
 * @method static \Illuminate\Database\Eloquent\Builder|WorkEpisodeTitle newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WorkEpisodeTitle newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WorkEpisodeTitle query()
 * @method static \Illuminate\Database\Eloquent\Builder|WorkEpisodeTitle whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkEpisodeTitle whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkEpisodeTitle whereLanguageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkEpisodeTitle whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkEpisodeTitle whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkEpisodeTitle whereWorkEpisodeId($value)
 * @mixin \Eloquent
 */
class WorkEpisodeTitle extends Model
{
    protected $guarded = ['id'];

    public function work_episode(): BelongsTo
    {
        return $this->belongsTo(WorkEpisode::class);
    }

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }
}
