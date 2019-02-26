<?php

namespace Reliqui\Ambulatory\Http\Controllers;

use Illuminate\Support\Str;
use Reliqui\Ambulatory\Http\Middleware\Admin;
use Reliqui\Ambulatory\ReliquiHealthcareLocation;
use Reliqui\Ambulatory\Http\Requests\LocationRequest;

class HealthcareLocationController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware(Admin::class)->except('index');
    }

    /**
     * Get locations.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $entries = ReliquiHealthcareLocation::orderBy('created_at', 'DESC')->paginate(25);

        return response()->json([
            'entries' => $entries,
        ]);
    }

    /**
     * Show the location.
     *
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        if ($id === 'new') {
            return response()->json([
                'entry' => ReliquiHealthcareLocation::make(['id' => Str::uuid()]),
            ]);
        }

        $entry = ReliquiHealthcareLocation::findOrFail($id);

        return response()->json([
            'entry' => $entry,
        ]);
    }

    /**
     * Store the location.
     *
     * @param LocationRequest $request
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(LocationRequest $request, $id)
    {
        $entry = $id !== 'new'
            ? ReliquiHealthcareLocation::findOrFail($id)
            : new ReliquiHealthcareLocation(['id' => request('id')]);

        $entry->fill($request->locationForm());
        $entry->save();

        return response()->json([
            'entry' => $entry,
        ]);
    }

    /**
     * Destroy the speciality.
     *
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $entry = ReliquiHealthcareLocation::findOrFail($id);

        $entry->delete();
    }
}
