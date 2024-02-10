<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\WorkListName
 *
 * @property-read \App\Models\Language $language
 * @property-read \App\Models\WorkList|null $work_list
 * @method static \Illuminate\Database\Eloquent\Builder|WorkListName newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WorkListName newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WorkListName query()
 * @property int $id
 * @property int $work_list_id
 * @property int $language_id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|WorkListName whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkListName whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkListName whereLanguageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkListName whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkListName whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WorkListName whereWorkListId($value)
 * @mixin \Eloquent
 */
class WorkListName extends Model
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
