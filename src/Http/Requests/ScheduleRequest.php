<?php

namespace Reliqui\Ambulatory\Http\Requests;

use Illuminate\Validation\Rule;
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
            'health_facility' => 'required|array',
            'health_facility.*id' => [
                'bail',
                'required',
                Rule::exists(config('ambulatory.database_connection').'.reliqui_health_facilities', 'id'),
                Rule::unique(config('ambulatory.database_connection').'.reliqui_schedules', 'health_facility_id')
                    ->ignore($this->id)
                    ->where('doctor_id', auth('ambulatory')->user()->doctorProfile->id),
            ],
            'start_date' => [
                'bail',
                'required',
                'date',
                'after_or_equal:'.today()->toDateString(),
            ],
            'end_date' => 'bail|required|date|after:start_date',
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
            'health_facility_id' => $this->health_facility['id'],
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'estimated_service_time_in_minutes' => $serviceTime,
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'health_facility.id' => 'Health facility',
        ];
    }
}
