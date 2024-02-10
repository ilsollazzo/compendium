<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /**
         * @var \App\Models\WorkList|JsonResource $this
         */
        return [
            'url'   => route('api.list.show', $this->slug),
            'names' => WorkListNameResource::collection($this->work_list_names),
            'works' => WorkResource::collection($this->whenLoaded('works')),
        ];
    }
}
