<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\CastRoleDetail
 *
 * @property int $id
 * @property int $cast_role_id
 * @property int $language_id
 * @property string $name
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|CastRoleDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CastRoleDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CastRoleDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder|CastRoleDetail whereCastRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CastRoleDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CastRoleDetail whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CastRoleDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CastRoleDetail whereLanguageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CastRoleDetail whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CastRoleDetail whereUpdatedAt($value)
 * @property-read \App\Models\CastRole $cast_role
 * @property-read \App\Models\Language $language
 * @mixin \Eloquent
 */
class CastRoleDetail extends Model
{
    protected $guarded = ['id'];

    public function cast_role(): BelongsTo
    {
        return $this->belongsTo(CastRole::class);
    }

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }
}
