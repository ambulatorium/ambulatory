<?php

namespace Ambulatory\Ambulatory\Http\Controllers;

use Ambulatory\Ambulatory\Schedule;
use Ambulatory\Ambulatory\Http\Middleware\VerifiedDoctor;
use Ambulatory\Ambulatory\Http\Requests\ScheduleAvailabilityRequest;

class ScheduleAvailabilityController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware(VerifiedDoctor::class)->except('index');
    }

    /**
     * Display a listing of the medical forms.
     *
     * @param  Schedule  $schedule
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Schedule $schedule)
    {
        $date = request('date') ?: today();

        return response()->json([
            'entries' => $schedule->availabilitySlots($date),
        ]);
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

        $schedule->addCustomAvailability($request->validated());

        return response()->json([
            'entry' => $schedule,
        ]);
    }
}
