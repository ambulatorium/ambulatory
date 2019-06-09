<?php

namespace Reliqui\Ambulatory\Tests\Feature;

use Reliqui\Ambulatory\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Reliqui\Ambulatory\Schedule;

class BookingScheduleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function exp_the_book()
    {
        $this->markTestSkipped();
        $this->signInAsPatient();

        $schedule = factory(Schedule::class)->create();

        $date = $this->pickDateBetween($schedule->start_date_time, $schedule->end_date_time);

        $resp = $this->postJson(route('ambulatory.bookings.store', $schedule->id), ['date' => $date]);

        dd($resp->assertExactJson(['']));
    }
}
