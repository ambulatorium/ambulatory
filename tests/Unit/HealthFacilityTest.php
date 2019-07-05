<?php

namespace Ambulatory\Ambulatory\Tests\Unit;

use Ambulatory\Ambulatory\HealthFacility;
use Ambulatory\Ambulatory\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HealthFacilityTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_sets_the_uuid_when_creating_a_new_health_facility()
    {
        $healthFacility = factory(HealthFacility::class)->create(['id' => '']);

        $this->assertNotNull($healthFacility->id);
    }

    /** @test */
    public function it_generate_the_slug_when_saving_a_new_health_facility()
    {
        $healthFacility = factory(HealthFacility::class)->create(['name' => 'Clinic Ambulatory', 'city' => 'Kuta']);

        $this->assertSame('clinic-ambulatory-kuta', $healthFacility->slug);

        $healthFacility = factory(HealthFacility::class)->create(['name' => 'Clinic Ambulatory', 'city' => 'Kuta']);

        $this->assertSame('clinic-ambulatory-kuta-0', $healthFacility->slug);
    }

    /** @test */
    public function it_generate_the_slug_with_a_name_or_city_that_ends_in_a_number()
    {
        $healthFacility = factory(HealthFacility::class)->create(['name' => 'AMBULATORY 01', 'city' => 'Kuta']);

        $this->assertSame('ambulatory-01-kuta', $healthFacility->slug);

        $healthFacility = factory(HealthFacility::class)->create(['name' => 'AMBULATORY 01', 'city' => 'Kuta']);

        $this->assertSame('ambulatory-01-kuta-0', $healthFacility->slug);
    }
}
