<?php

namespace Ambulatory\Http\Controllers;

use Ambulatory\Specialization;
use Ambulatory\Http\Middleware\Admin;
use Ambulatory\Http\Requests\SpecializationRequest;

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
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $specializations = Specialization::latest()->paginate(25);

        return response()->json([
            'entries' => $specializations,
        ]);
    }

    /**
     * Store a newly created specialization in storage.
     *
     * @param  SpecializationRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(SpecializationRequest $request)
    {
        $entry = Specialization::create($request->validated());

        return response()->json([
            'entry' => $entry,
        ]);
    }

    /**
     * Display the specified specialization.
     *
     * @param  Specialization  $specialization
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Specialization $specialization)
    {
        return response()->json([
            'entry' => $specialization,
        ]);
    }

    /**
     * Update the specified specialization in storage.
     *
     * @param  SpecializationRequest  $request
     * @param  Specialization  $specialization
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(SpecializationRequest $request, Specialization $specialization)
    {
        $specialization->update($request->validated());

        return response()->json([
            'entry' => $specialization,
        ]);
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
    }
}
