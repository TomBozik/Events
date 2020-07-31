<?php

namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class AnswerResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'from' => Carbon::createFromFormat('Y-m-d', $this->from)->format('d.m.Y'),
            'to' => Carbon::createFromFormat('Y-m-d', $this->to)->format('d.m.Y'),
        ];
    }
}
