<?php

namespace Reliqui\Ambulatory\Http\Controllers;

use Reliqui\Ambulatory\Schedule;
use Reliqui\Ambulatory\Http\Requests\ScheduleRequest;
use Reliqui\Ambulatory\Http\Middleware\VerifiedDoctor;

class ScheduleController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware(VerifiedDoctor::class);
    }

    /**
     * Display a listing of the schedules.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $schedules = Schedule::with('healthFacility')
            ->where('doctor_id', auth('ambulatory')->user()->doctorProfile->id)
            ->latest()
            ->paginate(25);

        return response()->json([
            'entries' => $schedules,
        ]);
    }

    /**
     * Store a newly created schedule in storage.
     *
     * @param  ScheduleRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ScheduleRequest $request)
    {
        $schedule = Schedule::create($request->validatedFields());

        return response()->json([
            'entry' => $schedule,
        ]);
    }

    /**
     * Display the specified schedule.
     *
     * @param  Schedule  $schedule
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Schedule $schedule)
    {
        $this->authorize('manage', $schedule);

        return response()->json([
            'entry' => $schedule->load('healthFacility'),
        ]);
    }

    /**
     * Update the specified schedule in storage.
     *
     * @param  ScheduleRequest  $request
     * @param  Schedule  $schedule
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ScheduleRequest $request, Schedule $schedule)
    {
        $this->authorize('manage', $schedule);

        $schedule->update($request->validatedFields());

        return response()->json([
            'entry' => $schedule,
        ]);
    }
}
