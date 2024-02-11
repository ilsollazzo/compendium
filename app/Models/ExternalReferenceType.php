<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\ExternalReferenceType
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ExternalReferenceType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ExternalReferenceType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ExternalReferenceType query()
 * @method static \Illuminate\Database\Eloquent\Builder|ExternalReferenceType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExternalReferenceType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExternalReferenceType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExternalReferenceType whereUpdatedAt($value)
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ExternalReference> $externalReferences
 * @property-read int|null $external_references_count
 * @property string $slug
 * @method static \Illuminate\Database\Eloquent\Builder|ExternalReferenceType whereSlug($value)
 * @property string|null $url_model
 * @method static \Illuminate\Database\Eloquent\Builder|ExternalReferenceType whereUrlModel($value)
 * @mixin \Eloquent
 */
class ExternalReferenceType extends Model
{
    protected $guarded = ['id'];
    public function externalReferences(): HasMany
    {
        return $this->hasMany(ExternalReference::class);
    }
}
