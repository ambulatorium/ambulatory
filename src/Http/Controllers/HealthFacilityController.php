<?php

namespace Ambulatory\Http\Controllers;

Use Ambulatory\HealthFacility;
Use Ambulatory\Http\Middleware\Admin;
Use Ambulatory\Http\Requests\HealthFacilityRequest;

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
     * Display a listing of the health facilities.
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
     * Store a newly created health facility in storage.
     *
     * @param  HealthFacilityRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(HealthFacilityRequest $request)
    {
        $entry = HealthFacility::create($request->validated());

        return response()->json([
            'entry' => $entry,
        ]);
    }

    /**
     * Display the specified medical form.
     *
     * @param  HealthFacility  $healthFacility
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(HealthFacility $healthFacility)
    {
        return response()->json([
            'entry' => $healthFacility,
        ]);
    }

    /**
     * Update the specified health facility in storage.
     *
     * @param  HealthFacilityRequest  $request
     * @param  HealthFacility  $healthFacility
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(HealthFacilityRequest $request, HealthFacility $healthFacility)
    {
        $healthFacility->update($request->validated());

        return response()->json([
            'entry' => $healthFacility,
        ]);
    }
}
