<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkTitleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /**
         * @var \App\Models\WorkTitle $this
         */
        return [
            'language' => $this->language->iso_639_1,
            'title'    => $this->title,
        ];
    }
}
