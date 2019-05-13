<?php

namespace Reliqui\Ambulatory\Tests\Unit;

use Reliqui\Ambulatory\HealthFacility;
use Reliqui\Ambulatory\Tests\TestCase;
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
        $healthFacility = factory(HealthFacility::class)->create(['name' => 'Reliqui Ambulatory', 'city' => 'Bali']);

        $this->assertSame('reliqui-ambulatory-bali', $healthFacility->slug);

        $healthFacility = factory(HealthFacility::class)->create(['name' => 'Reliqui Ambulatory', 'city' => 'Bali']);

        $this->assertSame('reliqui-ambulatory-bali-0', $healthFacility->slug);
    }

    /** @test */
    public function it_generate_the_slug_with_a_name_or_city_that_ends_in_a_number()
    {
        $healthFacility = factory(HealthFacility::class)->create(['name' => 'RELIQUI 01', 'city' => 'Bali']);

        $this->assertSame('reliqui-01-bali', $healthFacility->slug);

        $healthFacility = factory(HealthFacility::class)->create(['name' => 'RELIQUI 01', 'city' => 'Bali']);

        $this->assertSame('reliqui-01-bali-0', $healthFacility->slug);
    }
}
