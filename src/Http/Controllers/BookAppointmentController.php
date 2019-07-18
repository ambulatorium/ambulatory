<?php

namespace Ambulatory\Http\Controllers;

use Ambulatory\Schedule;
use Ambulatory\Http\Resources\BookingResource;
use Ambulatory\Http\Requests\BookAppointmentRequest;

class BookAppointmentController extends Controller
{
    /**
     * Display a listing of the schedule availability slots.
     *
     * @param  Schedule  $schedule
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Schedule $schedule)
    {
        $date = request('date') ?: today();

        return response()->json([
            'data' => $schedule->availabilitySlots($date),
        ]);
    }

    /**
     * Store a newly created booking in storage.
     *
     * @param  BookAppointmentRequest  $request
     * @param  Schedule  $schedule
     * @return \Illuminate\Http\Resources\Json\JsonResource|\Illuminate\Http\JsonResponse
     */
    public function store(BookAppointmentRequest $request, Schedule $schedule)
    {
        $booking = $schedule->bookings()->create($request->validated());

        return new BookingResource($booking);
    }
}
