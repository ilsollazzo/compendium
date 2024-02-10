<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\WorkDescriptionPart
 *
 * @property int $id
 * @property int $work_description_id
 * @property int $part_no
 * @property string $title
 * @property string $content
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\WorkDescription $work_description
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDescriptionPart newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDescriptionPart newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDescriptionPart query()
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDescriptionPart whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDescriptionPart whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDescriptionPart whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDescriptionPart wherePart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDescriptionPart whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDescriptionPart whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkDescriptionPart whereWorkDescriptionId($value)
 * @mixin \Eloquent
 */
class WorkDescriptionPart extends Model
{
    protected $guarded = ['id'];

    public function work_description(): BelongsTo
    {
        return $this->belongsTo(WorkDescription::class);
    }
}
