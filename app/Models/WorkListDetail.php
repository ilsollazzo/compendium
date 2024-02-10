<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\WorkListName
 *
 * @property-read \App\Models\Language $language
 * @property-read \App\Models\WorkList|null $work_list
 * @method static \Illuminate\Database\Eloquent\Builder|WorkListDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WorkListDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WorkListDetail query()
 * @property int $id
 * @property int $work_list_id
 * @property int $language_id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|WorkListDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkListDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkListDetail whereLanguageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkListDetail whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkListDetail whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkListDetail whereWorkListId($value)
 * @property string|null $description
 * @property string|null $notes
 * @method static \Illuminate\Database\Eloquent\Builder|WorkListDetail whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkListDetail whereNotes($value)
 * @mixin \Eloquent
 */
class WorkListDetail extends Model
{
    protected $guarded = ['id'];

    public function work_list(): BelongsTo
    {
        return $this->belongsTo(WorkList::class);
    }

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }
}
