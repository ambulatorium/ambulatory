<?php

namespace Ambulatory\Http\Controllers\Settings;

use Ambulatory\Doctor;
use Ambulatory\Http\Controllers\Controller;
use Ambulatory\Http\Middleware\Doctor as AmbulatoryDoctor;
use Ambulatory\Http\Requests\DoctorProfileRequest;
use Ambulatory\Http\Resources\DoctorResource;
use Ambulatory\Specialization;

class DoctorProfileController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware(AmbulatoryDoctor::class);
    }

    /**
     * Get doctors' profile.
     *
     * @return \Illuminate\Http\Resources\Json\JsonResource|\Illuminate\Http\JsonResponse
     */
    public function show(Doctor $doctor)
    {
        $this->authorize('update', $doctor);

        return new DoctorResource($doctor->load('specializations'));
    }

    /**
     * Store doctors' profile.
     *
     * @param  DoctorProfileRequest  $request
     * @return \Illuminate\Http\Resources\Json\JsonResource|\Illuminate\Http\JsonResponse
     */
    public function store(DoctorProfileRequest $request)
    {
        $doctor = Doctor::create($request->validatedFields() + ['user_id' => auth('ambulatory')->id()]);

        $doctor->specializations()->sync(
            $this->specializations(request('specializations'))
        );

        return new DoctorResource($doctor->load('specializations'));
    }

    /**
     * Update doctors' profile.
     *
     * @param  DoctorProfileRequest  $request
     * @param  Doctor  $doctor
     * @return \Illuminate\Http\Resources\Json\JsonResource|\Illuminate\Http\JsonResponse
     */
    public function update(DoctorProfileRequest $request, Doctor $doctor)
    {
        $this->authorize('update', $doctor);

        $doctor->update($request->validatedFields());

        $doctor->specializations()->sync(
            $this->specializations(request('specializations'))
        );

        return new DoctorResource($doctor->load('specializations'));
    }

    protected function specializations($specializations)
    {
        $allSpecializations = Specialization::all();

        return collect($specializations)->map(function ($specialization) use ($allSpecializations) {
            $speciality = $allSpecializations->where('id', $specialization['id'])->first();

            return (string) $speciality->id;
        })->toArray();
    }
}
