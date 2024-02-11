<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * App\Models\CastMember
 *
 * @property int $id
 * @property string|null $surname
 * @property string|null $name
 * @property string|null $pen_name
 * @property \Illuminate\Support\Carbon|null $birth_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\CastRole> $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Work> $works
 * @property-read int|null $works_count
 * @method static \Illuminate\Database\Eloquent\Builder|CastMember newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CastMember newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CastMember query()
 * @method static \Illuminate\Database\Eloquent\Builder|CastMember whereBirthDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CastMember whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CastMember whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CastMember whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CastMember wherePenName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CastMember whereSurname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CastMember whereUpdatedAt($value)
 * @property string|null $slug
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\WorkCastMembership> $memberships
 * @property-read int|null $memberships_count
 * @method static \Illuminate\Database\Eloquent\Builder|CastMember whereSlug($value)
 * @mixin \Eloquent
 */
class CastMember extends Model
{
    protected $guarded = ['id'];
    protected $casts = [
        'birth_date' => 'date'
    ];

    public function memberships(): BelongsToMany
    {
        return $this->belongsToMany(WorkCastMembership::class);
    }
}
