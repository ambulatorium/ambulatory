<?php

namespace Reliqui\Ambulatory\Http\Controllers;

use Reliqui\Ambulatory\Schedule;
use Reliqui\Ambulatory\Availability;
use Reliqui\Ambulatory\Http\Middleware\Doctor;
use Reliqui\Ambulatory\Http\Middleware\VerifiedDoctor;
use Reliqui\Ambulatory\Http\Requests\AvailabilityRequest;

class ScheduleAvailabilityController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware([Doctor::class, VerifiedDoctor::class]);
    }

    /**
     * Store a newly created availability in storage.
     *
     * @param  AvailabilityRequest  $request
     * @param  Schedule  $schedule
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(AvailabilityRequest $request, Schedule $schedule)
    {
        $this->authorize('manage', $schedule);

        $schedule->addAvailability($request->validated());

        return response()->json([
            'entry' => $schedule,
        ]);
    }

    /**
     * Update the specified availability in storage.
     *
     * @param  Schedule  $schedule
     * @param  Availability  $availability
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Schedule $schedule, Availability $availability)
    {
        $this->authorize('manage', $schedule);

        $availability->update(request()->validate([
            'date' => 'required|date',
            'intervals' => 'array',
        ]));

        return response()->json([
            'entry' => $schedule,
        ]);
    }
}
