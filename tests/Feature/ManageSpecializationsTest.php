<?php

namespace Ambulatory\Tests\Feature;

use Ambulatory\Specialization;
use Ambulatory\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManageSpecializationsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_can_not_manage_specializations()
    {
        $specializations = factory(Specialization::class)->create();

        $this->getJson(route('ambulatory.specializations'))->assertStatus(401);
        $this->postJson(route('ambulatory.specializations'), [])->assertStatus(401);
        $this->getJson(route('ambulatory.specializations.show', $specializations->id))->assertStatus(401);
        $this->patchJson(route('ambulatory.specializations.update', $specializations->id), [])->assertStatus(401);
        $this->deleteJson(route('ambulatory.specializations.destroy', $specializations->id))->assertStatus(401);
    }

    /** @test */
    public function unauthorized_users_can_not_create_a_new_specialization()
    {
        $this->signInAsDoctor();
        $this->postJson(route('ambulatory.specializations'), [])->assertStatus(403);

        $this->signInAsPatient();
        $this->postJson(route('ambulatory.specializations'), [])->assertStatus(403);
    }

    /** @test */
    public function admin_can_create_a_new_specialization()
    {
        $this->signInAsAdmin();

        $attrributes = factory(Specialization::class)->raw();

        $this->postJson(route('ambulatory.specializations.store'), $attrributes)
            ->assertStatus(201)
            ->assertJson($attrributes);

        $this->assertDatabaseHas('ambulatory_specializations', $attrributes);
    }

    /** @test */
    public function a_specialization_requires_a_name()
    {
        $this->signInAsAdmin();

        $attributes = factory(Specialization::class)->raw(['name' => '']);

        $this->postJson(route('ambulatory.specializations.store'), $attributes)
            ->assertExactJson([
                'errors' => [
                    'name' => ['The name field is required.'],
                ],
                'message' => 'The given data was invalid.',
            ]);

        $this->assertDatabaseMissing('ambulatory_specializations', $attributes);
    }

    /** @test */
    public function unauthorized_users_can_not_update_a_specialization()
    {
        $specialization = factory(Specialization::class)->create();

        $this->signInAsDoctor();
        $this->patchJson(route('ambulatory.specializations.update', $specialization->id), [])->assertStatus(403);

        $this->signInAsPatient();
        $this->patchJson(route('ambulatory.specializations.update', $specialization->id), [])->assertStatus(403);
    }

    /** @test */
    public function admin_can_update_a_specialization()
    {
        $specialization = factory(Specialization::class)->create();

        $this->signInAsAdmin();

        $this->patchJson(route('ambulatory.specializations.update', $specialization->id),
            $attributes = factory(Specialization::class)->raw([
                'name' => 'Name Changed',
            ]))
            ->assertOk()
            ->assertJson($attributes);

        $this->assertNotSame($specialization->slug, 'name-changed');

        $this->assertDatabaseHas('ambulatory_specializations', ['slug' => 'name-changed']);
    }

    /** @test */
    public function unauthorized_users_can_not_delete_a_specialization()
    {
        $specialization = factory(Specialization::class)->create();

        $this->signInAsDoctor();
        $this->deleteJson(route('ambulatory.specializations.destroy', $specialization->id))->assertStatus(403);

        $this->signInAsPatient();
        $this->deleteJson(route('ambulatory.specializations.destroy', $specialization->id))->assertStatus(403);
    }

    /** @test */
    public function admin_can_delete_a_specialization()
    {
        $this->signInAsAdmin();

        $specialization = factory(Specialization::class)->create();

        $this->deleteJson(route('ambulatory.specializations.destroy', $specialization->id))
            ->assertStatus(204);

        $this->assertDatabaseMissing('ambulatory_specializations', $specialization->toarray());
    }
}
