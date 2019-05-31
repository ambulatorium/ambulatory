<?php

namespace Reliqui\Ambulatory\Http\Controllers;

use Reliqui\Ambulatory\Schedule;
use Reliqui\Ambulatory\Http\Middleware\Doctor;
use Reliqui\Ambulatory\Http\Requests\ScheduleRequest;
use Reliqui\Ambulatory\Http\Middleware\VerifiedDoctor;

class ScheduleController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware([Doctor::class, VerifiedDoctor::class]);
    }

    /**
     * Get a doctors' schedules.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $entries = Schedule::with('healthFacility')
            ->where('doctor_id', auth('ambulatory')->user()->doctorProfile->id)
            ->latest()
            ->paginate(25);

        return response()->json([
            'entries' => $entries,
        ]);
    }

    /**
     * Show doctors' schedule.
     *
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $entry = auth('ambulatory')
            ->user()
            ->doctorProfile
            ->schedules()
            ->findOrFail($id);

        return response()->json([
            'entry' => $entry,
        ]);
    }

    /**
     * Store the doctors' schedule.
     *
     * @param ScheduleRequest $request
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ScheduleRequest $request, $id)
    {
        $entry = $id !== 'new'
            ? auth('ambulatory')
                ->user()
                ->doctorProfile
                ->schedules()
                ->findOrFail($id)
            : new Schedule();

        $entry->fill($request->validatedFields());
        $entry->save();

        return response()->json([
            'entry' => $entry,
        ]);
    }
}
