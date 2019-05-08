<?php

namespace Reliqui\Ambulatory\Http\Controllers\Settings;

use Illuminate\Support\Str;
use Reliqui\Ambulatory\User;
use Reliqui\Ambulatory\Doctor;
use Reliqui\Ambulatory\Specialization;
use Reliqui\Ambulatory\Http\Controllers\Controller;
use Reliqui\Ambulatory\Http\Requests\DoctorProfileRequest;

class DoctorProfileController extends Controller
{
    /**
     * Get doctors' profile.
     *
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        $doctorExists = $user->doctorProfile()->first();

        if (blank($doctorExists)) {
            return response()->json([
                'entry' => Doctor::make(['id' => Str::uuid()]),
            ]);
        }

        return response()->json([
            'entry' => $doctorExists->load('specializations'),
        ]);
    }

    /**
     * Store doctors' profile.
     *
     * @param DoctorProfileRequest $request
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(DoctorProfileRequest $request, $id)
    {
        $entry = Doctor::updateOrCreate(['user_id' => $id], $request->validatedFields());

        $entry->specializations()->sync(
            $this->collectSpecializations(request('specializations'))
        );

        return response()->json([
            'entry' => $entry->fresh(),
        ]);
    }

    /**
     * Specializations incoming from the request.
     *
     * @param array $requestSpecializations
     * @return array
     */
    private function collectSpecializations($requestSpecializations)
    {
        $allSpecializations = Specialization::all();

        return collect($requestSpecializations)->map(function ($requestSpeciality) use ($allSpecializations) {
            $speciality = $allSpecializations->where('id', $requestSpeciality['id'])->first();

            return (string) $speciality->id;
        })->toArray();
    }
}
