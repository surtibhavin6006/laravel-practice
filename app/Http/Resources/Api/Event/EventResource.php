<?php

namespace App\Http\Resources\Api\Event;

use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
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
            'id' => $this->id,
            'title' => $this->title,
            $this->mergeWhen( $request->route()->getName() == 'api.event.view',[
                'repeatOn' => $this->repeat_on,
                'repeatWeek' => $this->repeat_week,
                'repeatMonth' => $this->repeat_month,
                'startDate' => $this->start_date,
                'endDate' => $this->end_date,
                'endAfterOccurrences' => $this->end_after_occurrences,
            ])
        ];
    }
}
