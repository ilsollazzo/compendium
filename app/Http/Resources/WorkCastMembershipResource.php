<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkCastMembershipResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /**
         * @var \App\Models\WorkCastMembership|JsonResource $this
         */
        return [
            'person'  => new CastMemberResource($this->cast_member),
            'role'    => new CastRoleResource($this->cast_role),
            'episode' => $this->when($this->episode, new WorkEpisodeResource($this->episode)),
        ];
    }
}
