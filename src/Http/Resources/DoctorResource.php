<?php

namespace Ambulatory\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DoctorResource extends JsonResource
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
            'full_name' => $this->full_name,
            'slug' => $this->slug,
            'qualification' => $this->qualification,
            'practicing_from' => $this->practicing_from,
            'professional_statement' => $this->professional_statement,
            'is_active' => (bool) $this->is_active,
            'account' => new UserResource($this->whenLoaded('user')),
            'schedules' => ScheduleResource::collection($this->whenLoaded('schedules')),
            'specializations' => SpecializationResource::collection($this->whenLoaded('specializations')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
