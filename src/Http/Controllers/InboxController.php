<?php

namespace Reliqui\Ambulatory\Http\Controllers;

use Reliqui\Ambulatory\Booking;

class InboxController extends Controller
{
    /**
     * Get appointments to the user inbox.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $entries = auth('ambulatory')->user()
            ->inbox()
            ->with('schedule.doctor', 'schedule.healthFacility')
            ->paginate(25);

        return response()->json([
            'entries' => $entries,
        ]);
    }

    /**
     * Show the appointment to the user inbox.
     *
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $entry = auth('ambulatory')->user()
            ->inbox()
            ->with('schedule.doctor', 'schedule.healthFacility', 'medicalForm')
            ->findOrFail($id);

        return response()->json([
            'entry' => $entry,
        ]);
    }
}
