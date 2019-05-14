<?php

namespace Reliqui\Ambulatory\Tests\Unit;

use Reliqui\Ambulatory\Doctor;
use Reliqui\Ambulatory\Schedule;
use Illuminate\Support\Collection;
use Reliqui\Ambulatory\HealthFacility;
use Reliqui\Ambulatory\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ScheduleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_sets_the_uuid_when_creating_a_new_schedule()
    {
        $schedule = factory(Schedule::class)->create();

        $this->assertNotNull($schedule->id);
    }

    /** @test */
    public function it_belongs_to_a_health_facility()
    {
        $schedule = factory(Schedule::class)->create();

        $this->assertInstanceOf(HealthFacility::class, $schedule->healthFacility);
    }

    /** @test */
    public function it_belongs_to_a_doctor()
    {
        $schedule = factory(Schedule::class)->create();

        $this->assertInstanceOf(Doctor::class, $schedule->doctor);
    }

    /** @test */
    public function it_can_included_to_the_bookings()
    {
        $schedule = factory(Schedule::class)->create();

        $this->assertInstanceOf(Collection::class, $schedule->bookings);
    }
}
