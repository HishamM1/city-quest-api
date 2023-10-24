<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ActivityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'note' => $this->note,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'completed' => $this->completed,
            'public' => $this->public,
            'rate' => $this->rate,
            'city' => CityResource::make($this->whenLoaded('city')),
            'category' => CategoryResource::make($this->whenLoaded('category')),
            'media' => MediaResource::make($this->whenLoaded('media')),
        ];
    }
}
