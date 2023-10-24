<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'name' => $this->name,
            'username' => '@' . $this->username,
            'email' => $this->whenNotNull($this->email),
            'country' => CountryResource::make($this->whenLoaded('country')),
            'city' => CityResource::make($this->whenLoaded('city')),
            'media' => MediaResource::make($this->whenLoaded('media')),
            'likes' => LikeResource::collection($this->whenLoaded('likes')),
            'posts' => PostResource::collection($this->whenLoaded('posts')),
            'bio' => $this->whenNotNull($this->bio),
            'favourite_country' => $this->whenNotNull($this->favourite_country),
            'favourite_color' => $this->whenNotNull($this->favourite_color),
            'favourite_food' => $this->whenNotNull($this->favourite_food),
            'want_to_visit' => $this->whenNotNull($this->want_to_visit),
        ];
    }
}
