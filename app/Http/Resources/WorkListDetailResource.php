<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkListDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /**
         * @var \App\Models\WorkListDetail $this
         */
        return [
            'language'    => $this->language->iso_639_1,
            'name'        => $this->name,
            'description' => $this->description,
            'notes'       => $this->notes,
        ];
    }
}
