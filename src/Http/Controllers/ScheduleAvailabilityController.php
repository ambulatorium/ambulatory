<?php

namespace Ambulatory\Http\Controllers;

use Ambulatory\Http\Middleware\VerifiedDoctor;
use Ambulatory\Http\Requests\ScheduleAvailabilityRequest;
use Ambulatory\Http\Resources\AvailabilityResource;
use Ambulatory\Schedule;

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
     * Display a listing of the availability of schedule.
     *
     * @param  Schedule  $schedule
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Schedule $schedule)
    {
        // @todo Custom schedule availability.
    }

    /**
     * Store a newly created schedule availability in storage.
     *
     * @param  ScheduleAvailabilityRequest  $request
     * @param  Schedule  $schedule
     * @return \Illuminate\Http\Resources\Json\JsonResource|\Illuminate\Http\JsonResponse
     */
    public function store(ScheduleAvailabilityRequest $request, Schedule $schedule)
    {
        $this->authorize('manage', $schedule);

        $availability = $schedule->addCustomAvailability($request->validated());

        return new AvailabilityResource($availability);
    }
}
