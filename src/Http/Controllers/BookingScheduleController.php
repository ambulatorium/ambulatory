<?php

namespace Ambulatory\Ambulatory\Http\Controllers;

use Ambulatory\Ambulatory\Schedule;
use Ambulatory\Ambulatory\Http\Requests\BookingScheduleRequest;

class BookingScheduleController extends Controller
{
    /**
     * Store a newly created booking in storage.
     *
     * @param  BookingScheduleRequest  $request
     * @param  Schedule  $schedule
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(BookingScheduleRequest $request, Schedule $schedule)
    {
        $schedule->bookings()->create($request->validated());

        return response()->json([
            'message' => 'Schedule successfully booked',
        ], 200);
    }
}
