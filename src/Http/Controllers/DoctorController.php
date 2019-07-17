<?php

namespace Ambulatory\Http\Controllers;

use Ambulatory\Doctor;
use Ambulatory\Http\Resources\DoctorResource;

class DoctorController extends Controller
{
    /**
     * Display a listing of the doctors.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $doctors = Doctor::with('user', 'specializations')->latest()->paginate(25);

        return DoctorResource::collection($doctors);
    }

    /**
     * Display the specified doctor.
     *
     * @param  Doctor  $doctor
     * @return \Illuminate\Http\Resources\Json\JsonResource|\Illuminate\Http\JsonResponse
     */
    public function show(Doctor $doctor)
    {
        return new DoctorResource($doctor->load('user', 'specializations', 'schedules'));
    }
}
