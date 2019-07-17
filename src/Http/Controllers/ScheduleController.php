<?php

namespace Ambulatory\Http\Controllers;

use Ambulatory\Schedule;
use Ambulatory\Http\Requests\ScheduleRequest;
use Ambulatory\Http\Middleware\VerifiedDoctor;
use Ambulatory\Http\Resources\ScheduleResource;

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
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $schedules = Schedule::with('healthFacility')
            ->where('doctor_id', auth('ambulatory')->user()->doctorProfile->id)
            ->latest()
            ->paginate(25);

        return ScheduleResource::collection($schedules);
    }

    /**
     * Store a newly created schedule in storage.
     *
     * @param  ScheduleRequest  $request
     * @return \Illuminate\Http\Resources\Json\JsonResource|\Illuminate\Http\JsonResponse
     */
    public function store(ScheduleRequest $request)
    {
        $schedule = Schedule::create($request->validatedFields());

        return new ScheduleResource($schedule);
    }

    /**
     * Display the specified schedule.
     *
     * @param  Schedule  $schedule
     * @return \Illuminate\Http\Resources\Json\JsonResource|\Illuminate\Http\JsonResponse
     */
    public function show(Schedule $schedule)
    {
        $this->authorize('manage', $schedule);

        return new ScheduleResource($schedule->load('healthFacility'));
    }

    /**
     * Update the specified schedule in storage.
     *
     * @param  ScheduleRequest  $request
     * @param  Schedule  $schedule
     * @return \Illuminate\Http\Resources\Json\JsonResource|\Illuminate\Http\JsonResponse
     */
    public function update(ScheduleRequest $request, Schedule $schedule)
    {
        $this->authorize('manage', $schedule);

        $schedule->update($request->validatedFields());

        return new ScheduleResource($schedule);
    }
}
