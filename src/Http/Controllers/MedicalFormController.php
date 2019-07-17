<?php

namespace Ambulatory\Http\Controllers;

use Ambulatory\MedicalForm;
use Ambulatory\Http\Requests\MedicalFormRequest;
use Ambulatory\Http\Resources\MedicalFormResource;

class MedicalFormController extends Controller
{
    /**
     * Display a listing of the medical forms.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $medicalForms = MedicalForm::where('user_id', auth('ambulatory')->id())->paginate(25);

        return MedicalFormResource::collection($medicalForms);
    }

    /**
     * Store a newly created medical form in storage.
     *
     * @param  MedicalFormRequest  $request
     * @return \Illuminate\Http\Resources\Json\JsonResource|\Illuminate\Http\JsonResponse
     */
    public function store(MedicalFormRequest $request)
    {
        $medicalForm = MedicalForm::create($request->validated() + ['user_id' => auth('ambulatory')->id()]);

        return new MedicalFormResource($medicalForm);
    }

    /**
     * Display the specified medical form.
     *
     * @param  MedicalForm  $medicalForm
     * @return \Illuminate\Http\Resources\Json\JsonResource|\Illuminate\Http\JsonResponse
     */
    public function show(MedicalForm $medicalForm)
    {
        $this->authorize('manage', $medicalForm);

        return new MedicalFormResource($medicalForm->load('user'));
    }

    /**
     * Update the specified medical form in storage.
     *
     * @param  MedicalFormRequest  $request
     * @param  MedicalForm  $medicalForm
     * @return \Illuminate\Http\Resources\Json\JsonResource|\Illuminate\Http\JsonResponse
     */
    public function update(MedicalFormRequest $request, MedicalForm $medicalForm)
    {
        $this->authorize('manage', $medicalForm);

        $medicalForm->update($request->validated());

        return new MedicalFormResource($medicalForm);
    }
}
