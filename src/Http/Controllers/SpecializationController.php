<?php

namespace Ambulatory\Http\Controllers;

use Ambulatory\Http\Middleware\Admin;
use Ambulatory\Http\Requests\SpecializationRequest;
use Ambulatory\Http\Resources\SpecializationResource;
use Ambulatory\Specialization;

class SpecializationController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware(Admin::class)->except('index');
    }

    /**
     * Display a listing of the specializations.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $specializations = Specialization::latest()->paginate(25);

        return SpecializationResource::collection($specializations);
    }

    /**
     * Store a newly created specialization in storage.
     *
     * @param  SpecializationRequest  $request
     * @return \Illuminate\Http\Resources\Json\JsonResource|\Illuminate\Http\JsonResponse
     */
    public function store(SpecializationRequest $request)
    {
        $specialization = Specialization::create($request->validated());

        return new SpecializationResource($specialization);
    }

    /**
     * Display the specified specialization.
     *
     * @param  Specialization  $specialization
     * @return \Illuminate\Http\Resources\Json\JsonResource|\Illuminate\Http\JsonResponse
     */
    public function show(Specialization $specialization)
    {
        return new SpecializationResource($specialization);
    }

    /**
     * Update the specified specialization in storage.
     *
     * @param  SpecializationRequest  $request
     * @param  Specialization  $specialization
     * @return \Illuminate\Http\Resources\Json\JsonResource|\Illuminate\Http\JsonResponse
     */
    public function update(SpecializationRequest $request, Specialization $specialization)
    {
        $specialization->update($request->validated());

        return new SpecializationResource($specialization);
    }

    /**
     * Remove the specified specialization from storage.
     *
     * @param  Specialization  $specialization
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Specialization $specialization)
    {
        $specialization->delete();

        return response()->json(null, 204);
    }
}
