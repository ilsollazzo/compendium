<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkEpisodeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /**
         * @var \App\Models\WorkEpisode $this
         */
        return [
            'number' => $this->number,
            'titles' => WorkEpisodeTitlesResource::collection($this->work_episode_titles),
        ];
    }
}
