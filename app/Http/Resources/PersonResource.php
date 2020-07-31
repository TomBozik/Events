<?php

namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;

class PersonResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'answers' => AnswerResource::collection($this->answers),
        ];
    }
}
