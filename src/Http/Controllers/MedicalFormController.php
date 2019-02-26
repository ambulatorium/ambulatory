<?php

namespace Reliqui\Ambulatory\Http\Controllers;

use Illuminate\Support\Str;
use Reliqui\Ambulatory\ReliquiPatient;

class MedicalFormController
{
    /**
     * Get all medical form.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $entries = auth('reliqui')->user()->medicalForm()->paginate(25);

        return response()->json([
            'entries' => $entries
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
                'entry' => ReliquiPatient::make(['id' => Str::uuid()]),
            ]);
        }

        $entry = ReliquiPatient::findOrFail($id);

        return response()->json([
            'entry' => $entry,
        ]);
    }

    /**
     * Store the medical form.
     *
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function store($id)
    {
        $data = [
            'form_name' => request('form_name'),
            'patient_full_name' => request('patient_full_name'),
            'dob' =>  request('dob'),
            'gender' =>  request('gender'),
            'address' =>  request('address'),
            'city' => request('city'),
            'state' => request('state'),
            'zip_code' => request('zip_code'),
            'home_phone' => request('home_phone'),
            'cell_phone' => request('cell_phone'),
            'marital_status' => request('marital_status'),
            'user_id' => auth('reliqui')->id(),
        ];

        validator($data, [
            'form_name' => 'required|string',
            'patient_full_name' => 'required|string',
            'dob' => 'required|date',
            'gender' => 'required|string',
            'address' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'zip_code' => 'required|string',
            'cell_phone' => 'required|string',
            'marital_status' => 'required|string',
        ])->validate();

        $entry = $id !== 'new' ? ReliquiPatient::findOrFail($id) : new ReliquiPatient(['id' => request('id')]);

        $entry->fill($data);

        $entry->save();

        return response()->json([
            'entry' => $entry,
        ]);
    }

    /**
     * Destroy the medical form.
     *
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $entry = ReliquiPatient::findOrFail($id);

        $entry->delete();
    }
}