<?php

namespace Ambulatory\Http\Controllers;

use Ambulatory\HealthFacility;
use Ambulatory\Http\Middleware\Admin;
use Ambulatory\Http\Requests\HealthFacilityRequest;
use Ambulatory\Http\Resources\HealthFacilityResource;

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
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $healthFacilities = HealthFacility::latest()->paginate(25);

        return HealthFacilityResource::collection($healthFacilities);
    }

    /**
     * Store a newly created health facility in storage.
     *
     * @param  HealthFacilityRequest  $request
     * @return \Illuminate\Http\Resources\Json\JsonResource|\Illuminate\Http\JsonResponse
     */
    public function store(HealthFacilityRequest $request)
    {
        $healthFacility = HealthFacility::create($request->validated());

        return new HealthFacilityResource($healthFacility);
    }

    /**
     * Display the specified medical form.
     *
     * @param  HealthFacility  $healthFacility
     * @return \Illuminate\Http\Resources\Json\JsonResource|\Illuminate\Http\JsonResponse
     */
    public function show(HealthFacility $healthFacility)
    {
        return new HealthFacilityResource($healthFacility);
    }

    /**
     * Update the specified health facility in storage.
     *
     * @param  HealthFacilityRequest  $request
     * @param  HealthFacility  $healthFacility
     * @return \Illuminate\Http\Resources\Json\JsonResource|\Illuminate\Http\JsonResponse
     */
    public function update(HealthFacilityRequest $request, HealthFacility $healthFacility)
    {
        $healthFacility->update($request->validated());

        return new HealthFacilityResource($healthFacility);
    }
}
