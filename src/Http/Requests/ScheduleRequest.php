<?php

namespace Reliqui\Ambulatory\Http\Requests;

use Reliqui\Ambulatory\Schedule;
use Illuminate\Foundation\Http\FormRequest;

class ScheduleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'location' => 'required|string|exists:'.config('ambulatory.database_connection').'.reliqui_health_facilities,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'service_time' => 'nullable|integer',
        ];
    }

    /**
     * Set the validated fields request that apply to the model.
     *
     * @return array
     */
    public function validatedFields()
    {
        $serviceTime = $this->service_time === null
            ? Schedule::ESTIMATED_SERVICE_TIME
            : $this->service_time;

        return [
            'doctor_id' => auth('ambulatory')->user()->doctorProfile->id,
            'health_facility_id' => $this->location,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'estimated_service_time_in_minutes' => $serviceTime,
        ];
    }
}
