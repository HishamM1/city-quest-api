<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LikeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'like_id' => $this->id,
            'user' => UserResource::make($this->whenLoaded('user')),
            'id' => $this->likeable_id,
            'type' => $this->likeable_type,
            'created_at' => $this->created_at,
        ];
    }
}
