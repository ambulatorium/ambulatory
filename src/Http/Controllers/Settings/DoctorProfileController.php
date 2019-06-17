<?php

namespace Reliqui\Ambulatory\Http\Controllers\Settings;

use Reliqui\Ambulatory\Doctor;
use Reliqui\Ambulatory\Http\Controllers\Controller;
use Reliqui\Ambulatory\Http\Requests\DoctorProfileRequest;
use Reliqui\Ambulatory\Http\Middleware\Doctor as ReliquiDoctor;
use Reliqui\Ambulatory\Specialization;

class DoctorProfileController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware(ReliquiDoctor::class);
    }

    /**
     * Get doctors' profile.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Doctor $doctor)
    {
        return response()->json([
            'entry' => $doctor->load('specializations'),
        ]);
    }

    /**
     * Store doctors' profile.
     *
     * @param  DoctorProfileRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(DoctorProfileRequest $request)
    {
        $doctor = Doctor::create($request->validatedFields() + ['user_id' => auth('ambulatory')->id()]);

        $doctor->specializations()->sync(
            $this->specializations(request('specializations'))
        );

        return response()->json([
            'entry' => $doctor->fresh(),
        ]);
    }

    /**
     * Update doctors' profile.
     *
     * @param  DoctorProfileRequest  $request
     * @param  Doctor  $doctor
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(DoctorProfileRequest $request, Doctor $doctor)
    {
        $this->authorize('update', $doctor);

        $doctor->update($request->validatedFields());

        $doctor->specializations()->sync(
            $this->specializations(request('specializations'))
        );

        return response()->json([
            'entry' => $doctor,
        ]);
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
