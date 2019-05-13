<?php

namespace Reliqui\Ambulatory\Http\Controllers;

use Reliqui\Ambulatory\MedicalForm;
use Reliqui\Ambulatory\Http\Requests\MedicalFormRequest;

class MedicalFormController
{
    /**
     * Get all medical forms.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $user = auth('ambulatory')->user();

        $entries = $user->medicalForms()->paginate(25);

        return response()->json([
            'entries' => $entries,
        ]);
    }

    /**
     * Show the medical form.
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

        $entry = auth('ambulatory')->user()->medicalForms()->findOrFail($id);

        return response()->json([
            'entry' => $entry,
        ]);
    }

    /**
     * Store the medical form.
     *
     * @param MedicalFormRequest $request
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(MedicalFormRequest $request, $id)
    {
        $entry = $id !== 'new'
            ? auth('ambulatory')->user()->medicalForms()->findOrFail($id)
            : new MedicalForm();

        $entry->fill($request->validated() + ['user_id' => auth('ambulatory')->id()]);
        $entry->save();

        return response()->json([
            'entry' => $entry,
        ]);
    }
}
