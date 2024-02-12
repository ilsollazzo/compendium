<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkDescriptionPartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /**
         * @var \App\Models\WorkDescriptionPart $this
         */
        return [
            'image'   => route('works.descriptions.parts.image', [$this->work_description->work->slug, $this->work_description, $this]),
            'title'   => $this->title,
            'content' => $this->content,
        ];
    }
}
