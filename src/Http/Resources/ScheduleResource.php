<?php

namespace Ambulatory\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ScheduleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'estimated_service_time_in_minutes' => $this->estimated_service_time_in_minutes,
            'doctor' => new DoctorResource($this->whenLoaded('doctor')),
            'health_facility' => new HealthFacilityResource($this->whenLoaded('healthFacility')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
