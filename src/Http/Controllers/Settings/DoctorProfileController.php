<?php

namespace Reliqui\Ambulatory\Http\Controllers\Settings;

use Reliqui\Ambulatory\Doctor;
use Reliqui\Ambulatory\Http\Controllers\Controller;
use Reliqui\Ambulatory\Http\Requests\DoctorProfileRequest;
use Reliqui\Ambulatory\Http\Middleware\Doctor as ReliquiDoctor;

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
    public function show()
    {
        $user = auth('ambulatory')->user();

        if ($user->isVerifiedDoctor()) {
            return response()->json([
                'entry' => $user->doctorProfile->load('specializations'),
            ]);
        }

        return response()->json([
            'entry' => [],
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

        $doctor->specializations()->sync(request('specializations'));

        return response()->json([
            'entry' => $doctor->fresh(),
        ]);
    }

    /**
     * Update doctors' profile.
     *
     * @param  DoctorProfileRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(DoctorProfileRequest $request)
    {
        $user = auth('ambulatory')->user();

        tap($user->doctorProfile, function ($doctor) use ($request) {
            $doctor->update($request->validatedFields());

            $doctor->specializations()->sync($request->get('specializations'));
        });

        return response()->json([
            'entry' => $user->doctorProfile,
        ]);
    }
}
