<?php

namespace Ambulatory\Http\Controllers;

Use Ambulatory\Doctor;

class DoctorController extends Controller
{
    /**
     * Display a listing of the doctors.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $doctors = Doctor::with('user', 'specializations')->latest()->paginate(25);

        return response()->json([
            'entries' => $doctors,
        ]);
    }

    /**
     * Display the specified doctor.
     *
     * @param  Doctor  $doctor
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Doctor $doctor)
    {
        return response()->json([
            'entry' => $doctor->load('user', 'specializations', 'schedules.healthFacility'),
        ]);
    }
}
