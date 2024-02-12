<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkDescriptionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /**
         * @var \App\Models\WorkDescription $this
         */
        return [
            'language' => $this->language->iso_639_1,
            'parts'    => WorkDescriptionPartResource::collection($this->description_parts),
            'authors'  => WorkDescriptionAuthorResource::collection($this->authors),
            'is_ready' => $this->is_ready
        ];
    }
}
