<?php

namespace Ambulatory\Http\Controllers;

Use Ambulatory\MedicalForm;
Use Ambulatory\Http\Requests\MedicalFormRequest;

class MedicalFormController extends Controller
{
    /**
     * Display a listing of the medical forms.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $entries = MedicalForm::where('user_id', auth('ambulatory')->id())->paginate(25);

        return response()->json([
            'entries' => $entries,
        ]);
    }

    /**
     * Store a newly created medical form in storage.
     *
     * @param  MedicalFormRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(MedicalFormRequest $request)
    {
        $entry = MedicalForm::create($request->validated() + ['user_id' => auth('ambulatory')->id()]);

        return response()->json([
            'entry' => $entry,
        ]);
    }

    /**
     * Display the specified medical form.
     *
     * @param  MedicalForm  $medicalForm
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(MedicalForm $medicalForm)
    {
        $this->authorize('manage', $medicalForm);

        return response()->json([
            'entry' => $medicalForm,
        ]);
    }

    /**
     * Update the specified medical form in storage.
     *
     * @param  MedicalFormRequest  $request
     * @param  MedicalForm  $medicalForm
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(MedicalFormRequest $request, MedicalForm $medicalForm)
    {
        $this->authorize('manage', $medicalForm);

        $medicalForm->update($request->validated());

        return response()->json([
            'entry' => $medicalForm,
        ]);
    }
}
