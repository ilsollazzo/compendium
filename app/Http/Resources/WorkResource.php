<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /**
         * @var \App\Models\Work|JsonResource $this
         */
        return [
            'url'                 => route('api.works.show', $this->slug),
            'thumbnail'           => route('work.thumbnail', $this->slug),
            'titles'              => WorkTitleResource::collection($this->titles),
            'date'                => [
                'year' => $this->year,
                'day'  => $this->date,
            ],
            'end_date'            => $this->when($this->end_year, [
                'year' => $this->end_year,
                'day'  => $this->end_date,
            ]),
            'duration'            => $this->duration,
            'descriptions'        => WorkDescriptionResource::collection($this->whenLoaded('descriptions')),
            'studios'             => StudioResource::collection($this->whenLoaded('studios')),
            'contains_episodes'   => $this->contains_episodes,
            'is_accessible'       => $this->is_accessible,
            'is_available'        => $this->is_available,
            'is_published'        => $this->is_published,
            'is_lost'             => $this->is_lost,
            'episodes'            => $this->when($this->episodes->count(), WorkEpisodeResource::collection($this->whenLoaded('episodes'))),
            'cast_members'        => WorkCastMembershipResource::collection($this->whenLoaded('cast_memberships')),
            'lists'               => WorkListResource::collection($this->whenLoaded('work_lists')),
            'external_references' => ExternalReferenceResource::collection($this->whenLoaded('external_references')),
            'utils'               => json_decode($this->utils),
            'type'                => $this->work_type?->name,
        ];
    }
}
