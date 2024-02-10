<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\ExternalReference
 *
 * @property int $id
 * @property int $external_reference_type_id
 * @property string $url
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ExternalReference newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ExternalReference newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ExternalReference query()
 * @method static \Illuminate\Database\Eloquent\Builder|ExternalReference whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExternalReference whereExternalReferenceTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExternalReference whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExternalReference whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExternalReference whereUrl($value)
 * @property-read \App\Models\ExternalReferenceType $externalReferenceType
 * @property-read \App\Models\Work|null $work
 * @property int $work_id
 * @method static \Illuminate\Database\Eloquent\Builder|ExternalReference whereWorkId($value)
 * @property-read \App\Models\ExternalReferenceType $external_reference_type
 * @mixin \Eloquent
 */
class ExternalReference extends Model
{
    protected $guarded = ['id'];
    public function work(): BelongsTo
    {
        return $this->belongsTo(Work::class);
    }

    public function external_reference_type(): BelongsTo
    {
        return $this->belongsTo(ExternalReferenceType::class);
    }
}
