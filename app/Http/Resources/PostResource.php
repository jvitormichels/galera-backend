<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
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
            'text' => $this->text,
            'author' => $this->whenLoaded('user', function () {
                return $this->user->only(['id', 'name']);
            }),
            'comments' => $this->whenLoaded('comments', fn() => 
                CommentResource::collection($this->comments)
            ),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
