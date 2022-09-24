<?php

namespace App\Http\Resources\Api\Event;

use App\Models\EventHistory;
use Illuminate\Http\Resources\Json\JsonResource;

class EventHistoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'executed_on' => $this->{EventHistory::CREATED_AT}->format('Y-m-d h:i:s'),
            'isError' => !empty($this->{EventHistory::ERROR}),
            'error' => $this->{EventHistory::ERROR}
        ];
    }
}
