<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\CastRole
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|CastRole newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CastRole newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CastRole query()
 * @method static \Illuminate\Database\Eloquent\Builder|CastRole whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CastRole whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CastRole whereUpdatedAt($value)
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\CastRoleDetail> $cast_role_details
 * @property-read int|null $cast_role_details_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\CastMember> $cast_members
 * @property-read int|null $cast_members_count
 * @property string|null $slug
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\WorkCastMembership> $memberships
 * @property-read int|null $memberships_count
 * @method static \Illuminate\Database\Eloquent\Builder|CastRole whereSlug($value)
 * @mixin \Eloquent
 */
class CastRole extends Model
{
    protected $guarded = ['id'];

    public function memberships(): BelongsToMany
    {
        return $this->belongsToMany(WorkCastMembership::class);
    }

    public function cast_role_details(): HasMany
    {
        return $this->hasMany(CastRoleDetail::class);
    }
}
