<?php

namespace Reliqui\Ambulatory\Http\Controllers\Settings;

use Illuminate\Support\Str;
use Reliqui\Ambulatory\ReliquiUsers;
use Reliqui\Ambulatory\ReliquiDoctor;
use Reliqui\Ambulatory\ReliquiSpeciality;
use Reliqui\Ambulatory\Http\Controllers\Controller;
use Reliqui\Ambulatory\Http\Requests\DoctorProfileRequest;

class DoctorProfileController extends Controller
{
    /**
     * Get doctor's profile.
     *
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $user = ReliquiUsers::findOrFail($id);
        $entry = $user->doctor()->first();

        if (blank($entry)) {
            return response()->json([
                'entry' => ReliquiDoctor::make(['id' => Str::uuid()]),
            ]);
        }

        return response()->json([
            'entry' => $entry->load('specialties'),
        ]);
    }

    /**
     * Store doctor's profile.
     *
     * @param DoctorProfileRequest $request
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(DoctorProfileRequest $request, $id)
    {
        $entry = ReliquiDoctor::updateOrCreate(['user_id' => $id], $request->formDoctor());

        $entry->specialties()->sync(
            $this->collectSpecialties(request('specialities'))
        );

        return response()->json([
            'entry' => $entry->fresh(),
        ]);
    }

    /**
     * Specialities incoming from the request.
     *
     * @param array $requestSpecialities
     * @return array
     */
    private function collectSpecialties($requestSpecialities)
    {
        $allSpecialities = ReliquiSpeciality::all();

        return collect($requestSpecialities)->map(function ($requestSpeciality) use ($allSpecialities) {
            $speciality = $allSpecialities->where('id', $requestSpeciality['id'])->first();

            return (string) $speciality->id;
        })->toArray();
    }
}
