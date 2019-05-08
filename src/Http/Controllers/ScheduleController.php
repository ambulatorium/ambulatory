<?php

namespace Reliqui\Ambulatory\Http\Controllers;

use Illuminate\Support\Str;
use Reliqui\Ambulatory\Schedule;
use Reliqui\Ambulatory\Http\Middleware\Doctor;
use Reliqui\Ambulatory\Http\Requests\ScheduleRequest;

class ScheduleController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware(Doctor::class);
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
        if ($id === 'new') {
            return response()->json([
                'entry' => Schedule::make([
                    'id' => Str::uuid(),
                    'start_date_time' => now()->format('Y-m-d H:i:00'),
                    'end_date_time' => now()->format('Y-m-d H:i:00'),
                ]),
            ]);
        }

        $entry = Schedule::findOrFail($id);

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
            ? Schedule::findOrFail($id)
            : new Schedule(['id' => $request->validatedFields(['id'])]);

        $entry->fill($request->validatedFields());
        $entry->save();

        return response()->json([
            'entry' => $entry,
        ]);
    }
}
