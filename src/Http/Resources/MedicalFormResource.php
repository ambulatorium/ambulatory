<?php

namespace Ambulatory\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MedicalFormResource extends JsonResource
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
            'slug' => $this->slug,
            'form_name' => $this->form_name,
            'full_name' => $this->full_name,
            'dob' => $this->dob,
            'gender' => $this->gender,
            'address' => $this->address,
            'city' => $this->city,
            'state' => $this->state,
            'zip_code' => $this->zip_code,
            'home_phone' => $this->home_phone,
            'cell_phone' => $this->cell_phone,
            'marital_status' => $this->marital_status,
            'verified_at' => $this->verified_at,
            'account' => new UserResource($this->whenLoaded('user')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
