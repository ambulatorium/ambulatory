<?php

namespace Reliqui\Ambulatory\Tests\Feature;

use Reliqui\Ambulatory\Tests\TestCase;
use Reliqui\Ambulatory\HealthFacility;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManageHealthFacilityTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_cannot_manage_health_faclity()
    {
        $healthFacility = factory(HealthFacility::class)->create();

        $this->getJson(route('ambulatory.health-facilities.index'))->assertStatus(401);
        $this->getJson(route('ambulatory.health-facilities.show', $healthFacility->id))->assertStatus(401);
        $this->postJson(route('ambulatory.health-facilities.store', 'new'), $healthFacility->toArray())->assertStatus(401);
    }

    /** @test */
    public function unauthorized_users_cannot_create_a_new_health_facility()
    {
        $this->signInAsDoctor();
        $this->postJson(route('ambulatory.health-facilities.store', 'new'), [])->assertStatus(403);

        $this->signInAsPatient();
        $this->postJson(route('ambulatory.health-facilities.store', 'new'), [])->assertStatus(403);
    }

    /** @test */
    public function admin_can_create_a_new_health_facility()
    {
        $this->signInAsAdmin();

        $attrributes = factory(HealthFacility::class)->raw();

        $this->postJson(route('ambulatory.health-facilities.store', 'new'), $attrributes)
            ->assertOk()
            ->assertJson(["entry" => $attrributes]);

        $this->assertDatabaseHas('ambulatory_health_facilities', $attrributes);
    }

    /** @test */
    public function admin_can_get_a_single_health_facility()
    {
        $this->signInAsAdmin();

        $healthFacility = factory(HealthFacility::class)->create();

        $this->getJson(route('ambulatory.health-facilities.show', $healthFacility->id))
            ->assertOk()
            ->assertJson(["entry" => $healthFacility->toArray()]);

        $this->getJson(route('ambulatory.health-facilities.show', 'new'))
            ->assertOk()
            ->assertJson(["entry" => []]);
    }

    /** @test */
    public function unauthorized_users_cannot_update_a_health_facility()
    {
        $healthFaclity = factory(HealthFacility::class)->create();

        $this->signInAsDoctor();
        $this->postJson(route('ambulatory.health-facilities.store', $healthFaclity->id), [])->assertStatus(403);

        $this->signInAsPatient();
        $this->postJson(route('ambulatory.health-facilities.store', $healthFaclity->id), [])->assertStatus(403);
    }

    /** @test */
    public function admin_can_update_a_health_facility()
    {
        $healthFacility = factory(HealthFacility::class)->create();

        $this->signInAsAdmin();

        $this->postJson(route('ambulatory.health-facilities.store', $healthFacility->id), $attributes = factory(HealthFacility::class)->raw([
                'name' => 'Name Changed',
                'city' => 'City Changed',
            ]))
            ->assertOk()
            ->assertJson(["entry" => $attributes]);

        $this->assertNotSame($healthFacility->slug, 'name-changed-city-changed');

        $this->assertDatabaseHas('ambulatory_health_facilities', ['slug' => 'name-changed-city-changed']);
    }
}