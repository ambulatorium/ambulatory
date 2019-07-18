<?php

namespace Ambulatory\Tests\Feature;

use Ambulatory\MedicalForm;
use Illuminate\Support\Arr;
use Ambulatory\Tests\TestCase;
use Ambulatory\Http\Resources\MedicalFormResource;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManageMedicalFormTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_cannot_manage_the_medical_form()
    {
        $medicalForm = factory(MedicalForm::class)->create();

        $this->getJson(route('ambulatory.medical-forms'))->assertStatus(401);
        $this->postJson(route('ambulatory.medical-forms.store'), [])->assertStatus(401);
        $this->getJson(route('ambulatory.medical-forms.show', $medicalForm->id))->assertStatus(401);
        $this->patchJson(route('ambulatory.medical-forms.update', $medicalForm->id), [])->assertStatus(401);
    }

    /** @test */
    public function an_authenticated_user_can_get_a_list_of_their_medical_forms()
    {
        $medicalForm = factory(MedicalForm::class)->create();

        $this->actingAs($medicalForm->user, 'ambulatory')
            ->getJson(route('ambulatory.medical-forms'))
            ->assertOk()
            ->assertJson([
                'data' => [
                    [
                        'id' => $medicalForm->id,
                    ],
                ],
                'links' => [],
                'meta' => [],
            ])
            ->assertJsonCount(3); // data, links, meta;
    }

    /** @test */
    public function an_authenticated_user_cannot_get_a_list_of_medical_forms_of_others()
    {
        $this->signInAsPatient();

        $medicalForm = factory(MedicalForm::class)->create();

        $this->getJson(route('ambulatory.medical-forms'))
            ->assertOk()
            ->assertJsonMissing([
                'data' => [
                    [
                        'id' => $medicalForm->id,
                    ],
                ],
                'links' => [],
                'meta' => [],
            ])
            ->assertJsonCount(3); // data, links, meta
    }

    /** @test */
    public function an_authenticated_user_can_create_a_new_medical_form()
    {
        $this->signInAsPatient();

        $attributes = Arr::except(factory(MedicalForm::class)->raw(), ['user_id']);

        $this->post(route('ambulatory.medical-forms.store'), $attributes)
            ->assertStatus(201)
            ->assertJson($attributes);

        $this->assertDatabaseHas('ambulatory_medical_forms', Arr::prepend($attributes, auth('ambulatory')->id(), 'user_id'));
    }

    /** @test */
    public function an_authenticated_user_can_get_the_details_of_their_medical_forms()
    {
        $resource = (new MedicalFormResource($medicalForm = factory(MedicalForm::class)->create()));

        $this->actingAs($medicalForm->user, 'ambulatory')
            ->getJson(route('ambulatory.medical-forms.show', $medicalForm->id))
            ->assertOk()
            ->assertExactJson($resource->response()->getData(true));
    }

    /** @test */
    public function an_authenticated_user_can_not_get_the_details_of_medical_form_of_others()
    {
        $this->signInAsPatient();

        $resource = (new MedicalFormResource($medicalForm = factory(MedicalForm::class)->create()));

        $this->getJson(route('ambulatory.medical-forms.show', $medicalForm->id))
            ->assertStatus(403)
            ->assertJsonMissing($resource->response()->getData(true));
    }

    /** @test */
    public function an_authenticated_user_can_not_update_the_medical_form_of_others()
    {
        $this->signInAsPatient();

        $medicalForm = factory(MedicalForm::class)->create();

        $this->patchJson(route('ambulatory.medical-forms.update', $medicalForm->id), factory(MedicalForm::class)->raw())
            ->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_can_update_their_medical_form()
    {
        $user = $this->signInAsPatient();

        $medicalForm = factory(MedicalForm::class)->create(['user_id' => $user->id]);

        $this->patchJson(route('ambulatory.medical-forms.update', $medicalForm->id),
            $attributes = factory(MedicalForm::class)->raw([
                'user_id' => $user->id,
                'form_name' => 'Form Name Changed',
                'full_name' => 'Full Name Changed',
            ]))
            ->assertOk()
            ->assertJson(Arr::except($attributes, ['user_id']));

        $this->assertNotSame($medicalForm->slug, 'form-name-changed-full-name-changed');

        $this->assertDatabaseHas('ambulatory_medical_forms', $attributes);
    }
}
