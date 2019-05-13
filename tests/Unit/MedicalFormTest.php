<?php

namespace Reliqui\Ambulatory\Tests\Unit;

use Reliqui\Ambulatory\User;
use Illuminate\Support\Collection;
use Reliqui\Ambulatory\MedicalForm;
use Reliqui\Ambulatory\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MedicalFormTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_sets_the_uuid_when_creating_a_new_medical_form()
    {
        $medicalForm = factory(MedicalForm::class)->create();

        $this->assertNotNull($medicalForm->id);
    }

    /** @test */
    public function it_generate_the_slug_when_saving_a_new_medical_form()
    {
        $medicalForm = factory(MedicalForm::class)->create(['form_name' => 'My Form', 'full_name' => 'David Sianturi']);

        $this->assertSame('my-form-david-sianturi', $medicalForm->slug);

        $medicalForm = factory(MedicalForm::class)->create(['form_name' => 'My Form', 'full_name' => 'David Sianturi']);

        $this->assertSame('my-form-david-sianturi-0', $medicalForm->slug);
    }

    /** @test */
    public function it_belongs_to_a_user()
    {
        $medicalForm = factory(MedicalForm::class)->create();

        $this->assertInstanceOf(User::class, $medicalForm->user);
    }

    /** @test */
    public function it_can_included_to_book_an_appointments()
    {
        $medicalForm = factory(MedicalForm::class)->create();

        $this->assertInstanceOf(Collection::class, $medicalForm->appointments);
    }
}
