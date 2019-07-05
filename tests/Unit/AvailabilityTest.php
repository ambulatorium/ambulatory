<?php

namespace Ambulatory\Ambulatory\Tests\Unit;

use Ambulatory\Ambulatory\Schedule;
use Ambulatory\Ambulatory\Availability;
use Ambulatory\Ambulatory\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AvailabilityTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_sets_the_uuid_when_creating_a_new_availability()
    {
        $availability = factory(Availability::class)->create();

        $this->assertNotNull($availability->id);
    }

    /** @test */
    public function it_belongs_to_a_schedule()
    {
        $availability = factory(Availability::class)->create();

        $this->assertInstanceOf(Schedule::class, $availability->schedule);
    }
}
