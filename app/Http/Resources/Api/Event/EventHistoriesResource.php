<?php

namespace App\Http\Resources\Api\Event;

use Illuminate\Http\Resources\Json\ResourceCollection;

class EventHistoriesResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return EventHistoryResource::collection($this);
    }
}
