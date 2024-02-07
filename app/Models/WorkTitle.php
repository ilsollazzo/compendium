<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Title
 *
 * @property-read \App\Models\Work $work
 * @method static \Illuminate\Database\Eloquent\Builder|WorkTitle newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WorkTitle newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WorkTitle query()
 * @property int $id
 * @property int $work_id
 * @property int $language_id
 * @property string $title
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Language $language
 * @method static \Illuminate\Database\Eloquent\Builder|WorkTitle whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkTitle whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkTitle whereLanguageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkTitle whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkTitle whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkTitle whereWorkId($value)
 * @mixin \Eloquent
 */
class WorkTitle extends Model
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
}
