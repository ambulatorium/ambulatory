<?php

namespace Reliqui\Ambulatory\Tests\Feature;

use Reliqui\Ambulatory\MedicalForm;
use Reliqui\Ambulatory\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManageMedicalFormTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_cannot_manage_medical_form()
    {
        $medicalForm = factory(MedicalForm::class)->create();

        $this->getJson(route('ambulatory.medical-forms'))->assertStatus(401);
        $this->postJson(route('ambulatory.medical-forms.store'), [])->assertStatus(401);
        $this->getJson(route('ambulatory.medical-forms.show', $medicalForm->id))->assertStatus(401);
        $this->patchJson(route('ambulatory.medical-forms.update', $medicalForm->id), [])->assertStatus(401);
    }

    /** @test */
    public function a_user_can_create_a_new_medical_form()
    {
        $user = $this->signInAsPatient();

        $medicalForm = factory(MedicalForm::class)->raw(['user_id' => $user->id]);

        $this->post(route('ambulatory.medical-forms.store'), $medicalForm)
            ->assertOk()
            ->assertJson(['entry' => $medicalForm]);

        $this->assertDatabaseHas('ambulatory_medical_forms', $medicalForm);
    }

    /** @test */
    public function an_authenticated_user_can_get_the_details_about_their_medical_forms()
    {
        $user = $this->signInAsPatient();

        $medicalForm = factory(MedicalForm::class)->create(['user_id' => $user->id]);

        $this->getJson(route('ambulatory.medical-forms.show', $medicalForm->id))
            ->assertOk()
            ->assertJson(['entry' => $medicalForm->toArray()]);
    }

    /** @test */
    public function an_authenticated_user_can_not_get_the_details_about_medical_form_of_others()
    {
        $this->signInAsPatient();

        $medicalForm = factory(MedicalForm::class)->create();

        $this->getJson(route('ambulatory.medical-forms.show', $medicalForm->id))->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_can_not_update_the_medical_form_of_others()
    {
        $this->signInAsPatient();

        $medicalForm = factory(MedicalForm::class)->create();

        $this->patchJson(route('ambulatory.medical-forms.update', $medicalForm->id),
            factory(MedicalForm::class)->raw())
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
            ->assertJson(['entry' => $attributes]);

        $this->assertNotSame($medicalForm->slug, 'form-name-changed-full-name-changed');

        $this->assertDatabaseHas('ambulatory_medical_forms', $attributes);
    }
}
