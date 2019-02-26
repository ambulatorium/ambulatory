<?php

namespace Reliqui\Ambulatory\Http\Controllers;

use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Reliqui\Ambulatory\ReliquiWorkingHours;
use Reliqui\Ambulatory\Http\Middleware\Doctor;
use Reliqui\Ambulatory\Http\Requests\WorkingHoursRequest;

class WorkingHoursController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware(Doctor::class);
    }

    /**
     * Get a doctor's schedules.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $entries = ReliquiWorkingHours::with('workLocation')
            ->where('doctor_id', auth('reliqui')->user()->doctor->id)
            ->paginate(25);

        return response()->json([
            'entries' => $entries,
        ]);
    }

    /**
     * Show doctor's schedule
     *
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        if ($id === 'new') {
            return response()->json([
                'entry' => ReliquiWorkingHours::make([
                    'id' => Str::uuid(),
                    'start_date_time' => now()->format('Y-m-d H:i:00'),
                    'end_date_time' => now()->format('Y-m-d H:i:00'),
                ]),
            ]);
        }

        $entry = ReliquiWorkingHours::findOrFail($id);

        return response()->json([
            'entry' => $entry,
        ]);
    }

    /**
     * Store the doctor's schedule
     *
     * @param WorkingHoursRequest $request
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(WorkingHoursRequest $request, $id)
    {
        $entry = $id !== 'new'
            ? ReliquiWorkingHours::findOrFail($id)
            : new ReliquiWorkingHours(['id' => request('id')]);

        $entry->fill($request->workingHoursForm());

        $entry->save();

        return response()->json([
            'entry' => $entry,
        ]);
    }
}
