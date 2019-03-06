<?php

namespace Reliqui\Ambulatory\Http\Controllers;

use Illuminate\Support\Str;
use Reliqui\Ambulatory\ReliquiSpeciality;
use Reliqui\Ambulatory\Http\Middleware\Admin;

class SpecialityController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware(Admin::class)->except('index');
    }

    /**
     * Get specialities.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $entries = ReliquiSpeciality::orderBy('created_at', 'DESC')->paginate(25);

        return response()->json([
            'entries' => $entries,
        ]);
    }

    /**
     * Show the speciality.
     *
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        if ($id === 'new') {
            return response()->json([
                'entry' => ReliquiSpeciality::make(['id' => Str::uuid()]),
            ]);
        }

        $entry = ReliquiSpeciality::findOrFail($id);

        return response()->json([
            'entry' => $entry,
        ]);
    }

    /**
     * Store the speciality.
     *
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function store($id)
    {
        $data = [
            'name' => request('name'),
            'description' => request('description'),
        ];

        validator($data, [
            'name' => 'required|string',
            'description' => 'nullable|string',
        ])->validate();

        $entry = $id !== 'new' ? ReliquiSpeciality::findOrFail($id) : new ReliquiSpeciality(['id' => request('id')]);

        $entry->fill($data);

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
        $entry = ReliquiSpeciality::findOrFail($id);

        $entry->delete();
    }
}
