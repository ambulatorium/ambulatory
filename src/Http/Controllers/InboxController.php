<?php

namespace Reliqui\Ambulatory\Http\Controllers;

use Reliqui\Ambulatory\ReliquiAppointment;

class InboxController extends Controller
{
    /**
     * Get appointments.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $entries = auth('reliqui')->user()->inbox();

        return response()->json([
            'entries' => $entries,
        ]);
    }

    /**
     * Show appointment.
     *
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $entry = ReliquiAppointment::with('patient', 'scheduled.workLocation')->findOrFail($id);

        return response()->json([
            'entry' => $entry,
        ]);
    }
}
