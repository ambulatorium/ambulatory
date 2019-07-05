<?php

namespace Ambulatory\Ambulatory\Tests\Unit;

use Ambulatory\Ambulatory\Booking;
use Ambulatory\Ambulatory\Schedule;
use Ambulatory\Ambulatory\MedicalForm;
use Ambulatory\Ambulatory\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookingTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_sets_the_uuid_when_creating_a_new_booking()
    {
        $booking = factory(Booking::class)->create();

        $this->assertNotNull($booking->id);
    }

    /** @test */
    public function it_belongs_to_the_doctor_schedule()
    {
        $booking = factory(Booking::class)->create();

        $this->assertInstanceOf(Schedule::class, $booking->schedule);
    }

    /** @test */
    public function it_belongs_to_the_medical_form()
    {
        $booking = factory(Booking::class)->create();

        $this->assertInstanceOf(MedicalForm::class, $booking->medicalForm);
    }
}
