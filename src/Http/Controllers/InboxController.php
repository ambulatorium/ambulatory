<?php

namespace Ambulatory\Http\Controllers;

use Ambulatory\Http\Resources\BookingResource;

class InboxController extends Controller
{
    /**
     * Get appointments to the user inbox.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $bookings = auth('ambulatory')->user()
            ->inbox()
            ->with('schedule.doctor', 'schedule.healthFacility')
            ->paginate(25);

        return BookingResource::collection($bookings);
    }

    /**
     * Show the appointment to the user inbox.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Resources\Json\JsonResource|\Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $booking = auth('ambulatory')->user()
            ->inbox()
            ->with('schedule.doctor', 'schedule.healthFacility', 'medicalForm')
            ->findOrFail($id);

        return new BookingResource($booking);
    }
}
