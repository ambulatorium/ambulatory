<?php

namespace Reliqui\Ambulatory\Http\Controllers;

use Reliqui\Ambulatory\HealthFacility;
use Reliqui\Ambulatory\Http\Middleware\Admin;
use Reliqui\Ambulatory\Http\Requests\HealthFacilityRequest;

class HealthFacilityController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware(Admin::class)->except('index');
    }

    /**
     * Get all health facilities.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $entries = HealthFacility::latest()->paginate(25);

        return response()->json([
            'entries' => $entries,
        ]);
    }

    /**
     * Show the health facility.
     *
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        if ($id === 'new') {
            return response()->json([
                'entry' => [],
            ]);
        }

        $entry = HealthFacility::findOrFail($id);

        return response()->json([
            'entry' => $entry,
        ]);
    }

    /**
     * Store the health facility.
     *
     * @param HealthFacilityRequest $request
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(HealthFacilityRequest $request, $id)
    {
        $entry = $id !== 'new'
            ? HealthFacility::findOrFail($id)
            : new HealthFacility();

        $entry->fill($request->validated());
        $entry->save();

        return response()->json([
            'entry' => $entry,
        ]);
    }
}
