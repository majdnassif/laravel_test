<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'user' => $this->user,
            'content' => $this->content,
            'images'=>$this->images ,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
