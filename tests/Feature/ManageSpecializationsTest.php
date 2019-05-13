<?php

namespace Reliqui\Ambulatory\Tests\Feature;

use Reliqui\Ambulatory\Specialization;
use Reliqui\Ambulatory\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManageSpecializationsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_cannot_manage_specializations()
    {
        $specializations = factory(Specialization::class)->create();

        $this->getJson(route('ambulatory.specializations.index'))->assertStatus(401);
        $this->getJson(route('ambulatory.specializations.show', $specializations->id))->assertStatus(401);
        $this->postJson(route('ambulatory.specializations.store', 'new'), $specializations->toArray())->assertStatus(401);
        $this->deleteJson(route('ambulatory.specializations.destroy', $specializations->id))->assertStatus(401);
    }

    /** @test */
    public function unauthorized_users_cannot_create_a_new_specialization()
    {
        $this->signInAsDoctor();
        $this->postJson(route('ambulatory.specializations.store', 'new'), [])->assertStatus(403);

        $this->signInAsPatient();
        $this->postJson(route('ambulatory.specializations.store', 'new'), [])->assertStatus(403);
    }

    /** @test */
    public function admin_can_create_a_new_specialization()
    {
        $this->signInAsAdmin();

        $attrributes = factory(Specialization::class)->raw();

        $this->postJson(route('ambulatory.specializations.store', 'new'), $attrributes)
            ->assertOk()
            ->assertJson(['entry' => $attrributes]);

        $this->assertDatabaseHas('ambulatory_specializations', $attrributes);
    }

    /** @test */
    public function a_specialization_requires_a_name()
    {
        $this->signInAsAdmin();

        $attributes = factory(Specialization::class)->raw(['name' => '']);

        $this->postJson(route('ambulatory.specializations.store', 'new'), $attributes)
            ->assertJson([
                'errors' => [
                    'name' => ['The name field is required.'],
                ],
            ]);

        $this->assertDatabaseMissing('ambulatory_specializations', $attributes);
    }

    /** @test */
    public function admin_can_get_a_single_specialization()
    {
        $this->signInAsAdmin();

        $specialization = factory(Specialization::class)->create();

        $this->getJson(route('ambulatory.specializations.show', $specialization->id))
            ->assertOk()
            ->assertJson(['entry' => $specialization->toArray()]);
    }

    /** @test */
    public function unauthorized_users_cannot_update_a_specialization()
    {
        $specialization = factory(Specialization::class)->create();

        $this->signInAsDoctor();
        $this->postJson(route('ambulatory.specializations.store', $specialization->id), [])->assertStatus(403);

        $this->signInAsPatient();
        $this->postJson(route('ambulatory.specializations.store', $specialization->id), [])->assertStatus(403);
    }

    /** @test */
    public function admin_can_update_a_specialization()
    {
        $specialization = factory(Specialization::class)->create();

        $this->signInAsAdmin();

        $this->postJson(route('ambulatory.specializations.store', $specialization->id), $attributes = factory(Specialization::class)->raw(['name' => 'Name Changed']))
            ->assertOk()
            ->assertJson(['entry' => $attributes]);

        $this->assertNotSame($specialization->slug, 'name-changed');

        $this->assertDatabaseHas('ambulatory_specializations', ['slug' => 'name-changed']);
    }

    /** @test */
    public function unauthorized_users_cannot_delete_a_specialization()
    {
        $specialization = factory(Specialization::class)->create();

        $this->signInAsDoctor();
        $this->deleteJson(route('ambulatory.specializations.store', $specialization->id))->assertStatus(403);

        $this->signInAsPatient();
        $this->deleteJson(route('ambulatory.specializations.store', $specialization->id))->assertStatus(403);
    }

    /** @test */
    public function admin_can_delete_a_specialization()
    {
        $specialization = factory(Specialization::class)->create();

        $this->signInAsAdmin();

        $this->deleteJson(route('ambulatory.specializations.store', $specialization->id))->assertOk();

        $this->assertDatabaseMissing('ambulatory_specializations', $specialization->toarray());
    }
}
