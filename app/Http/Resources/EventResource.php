<?php

namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
            // 'max_answers' => $this->max_answers,
        ];
    }
}
