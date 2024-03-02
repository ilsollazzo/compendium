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
            'url'     => route('api.lists.show', $this->slug),
            'details' => WorkListDetailResource::collection($this->work_list_details),
            'works'   => WorkResource::collection($this->whenLoaded('works')),
        ];
    }
}
