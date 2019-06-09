<?php

namespace Reliqui\Ambulatory\Http\Controllers;

use Reliqui\Ambulatory\Schedule;
use Reliqui\Ambulatory\Http\Middleware\VerifiedDoctor;
use Reliqui\Ambulatory\Http\Requests\ScheduleAvailabilityRequest;

class ScheduleAvailabilityController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware(VerifiedDoctor::class);
    }

    /**
     * Store a newly created schedule availability in storage.
     *
     * @param  ScheduleAvailabilityRequest  $request
     * @param  Schedule  $schedule
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ScheduleAvailabilityRequest $request, Schedule $schedule)
    {
        $this->authorize('manage', $schedule);

        $schedule->addAvailability($request->validated());

        return response()->json([
            'entry' => $schedule,
        ]);
    }
}
