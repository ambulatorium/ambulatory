<?php

namespace Reliqui\Ambulatory\Http\Controllers;

use Reliqui\Ambulatory\Specialization;
use Reliqui\Ambulatory\Http\Middleware\Admin;
use Reliqui\Ambulatory\Http\Requests\SpecializationRequest;

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
     * Get all specializations.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $entries = Specialization::latest()->paginate(25);

        return response()->json([
            'entries' => $entries,
        ]);
    }

    /**
     * Show the specialization.
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

        $entry = Specialization::findOrFail($id);

        return response()->json([
            'entry' => $entry,
        ]);
    }

    /**
     * Store the specialization.
     *
     * @param SpecializationRequest $request
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(SpecializationRequest $request, $id)
    {
        $entry = $id !== 'new'
            ? Specialization::findOrFail($id)
            : new Specialization();

        $entry->fill($request->validated());
        $entry->save();

        return response()->json([
            'entry' => $entry,
        ]);
    }

    /**
     * Destroy the specialization.
     *
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $entry = Specialization::findOrFail($id);

        $entry->delete();
    }
}
