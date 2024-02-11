<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\WorkCastMember
 *
 * @property int $id
 * @property int $work_id
 * @property int $cast_member_id
 * @property int $cast_role_id
 * @property int|null $work_episode_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\CastMember $cast_member
 * @property-read \App\Models\CastRole $cast_role
 * @property-read \App\Models\Work $work
 * @method static \Illuminate\Database\Eloquent\Builder|WorkCastMembership newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WorkCastMembership newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WorkCastMembership query()
 * @method static \Illuminate\Database\Eloquent\Builder|WorkCastMembership whereCastMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkCastMembership whereCastRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkCastMembership whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkCastMembership whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkCastMembership whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkCastMembership whereWorkEpisodeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkCastMembership whereWorkId($value)
 * @property-read \App\Models\WorkEpisode|null $episode
 * @property string $notes
 * @method static \Illuminate\Database\Eloquent\Builder|WorkCastMembership whereNotes($value)
 * @mixin \Eloquent
 */
class WorkCastMembership extends Model
{
    protected $guarded = ['id'];

    public function work(): BelongsTo
    {
        return $this->belongsTo(Work::class);
    }

    public function cast_member(): BelongsTo
    {
        return $this->belongsTo(CastMember::class);
    }

    public function cast_role(): BelongsTo
    {
        return $this->belongsTo(CastRole::class);
    }

    public function episode(): BelongsTo
    {
        return $this->belongsTo(WorkEpisode::class);
    }
}
