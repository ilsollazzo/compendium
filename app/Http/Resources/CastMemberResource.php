<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CastMemberResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /**
         * @var \App\Models\CastMember $this
         */
        return [
            'surname'    => $this->surname,
            'name'       => $this->name,
            'pen_name'   => $this->pen_name,
            'birth_date' => $this->birth_date,
        ];
    }
}
