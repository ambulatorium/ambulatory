<?php

namespace Ambulatory\Ambulatory\Http\Requests;

use RRule\RRule;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class DoctorProfileRequest extends FormRequest
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
            'full_name' => 'required|string|max:255',
            'qualification' => 'required|string|max:255',
            'practicing_from' => 'required|date|max:255',
            'professional_statement' => 'nullable|string|min:2|max:255',
            'specializations' => 'required|array',
            'specializations.*.id' => Rule::exists(config('ambulatory.database_connection').'.ambulatory_specializations', 'id'),
        ];
    }

    /**
     * Set the validated fields request that apply to the model.
     *
     * @return array
     */
    public function validatedFields()
    {
        return [
            'full_name' => $this->full_name,
            'qualification' => $this->qualification,
            'practicing_from' => $this->practicing_from,
            'professional_statement' => $this->professional_statement,
            'working_hours_rule' => $this->setDefaultWorkingHours(),
        ];
    }

    /**
     * Set the default working hours rule.
     *
     * @return string
     */
    protected function setDefaultWorkingHours()
    {
        $rule = new RRule([
            'freq' => 'daily',
            'byday' => 'MO,TU,WE,TH,FR',
            'dtstart' => today()->createFromTime(9, 0, 0),
            'until' => today()->createFromTime(17, 00, 00),
        ]);

        return $rule->rfcString();
    }
}
