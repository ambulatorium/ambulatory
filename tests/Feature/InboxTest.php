<?php

namespace Ambulatory\Tests\Feature;

use Ambulatory\Booking;
use Ambulatory\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InboxTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_cannot_access_the_inbox()
    {
        $this->getJson(route('ambulatory.inbox'))->assertStatus(401);
        $this->getJson(route('ambulatory.inbox.show', 'id'))->assertStatus(401);
    }

    /** @test */
    public function authenticated_user_only_get_their_list_of_bookings_on_their_inbox()
    {
        $booking = factory(Booking::class)->create();
        $otherBooking = factory(Booking::class)->create();

        $this->actingAs($booking->medicalForm->user, 'ambulatory')
            ->getJson(route('ambulatory.inbox'))
            ->assertOk()
            ->assertJson([
                'data' => [
                    [
                        'id' => $booking->id,
                        'doctor' => [
                            'id' => $booking->schedule->doctor->id,
                        ],
                        'health_facility' => [
                            'id' => $booking->schedule->healthFacility->id,
                        ],
                    ],
                ],
            ])
            ->assertJsonMissing([
                'data' => [
                    [
                        'id' => $otherBooking->id,
                        'doctor' => [
                            'id' => $otherBooking->schedule->doctor->id,
                        ],
                        'health_facility' => [
                            'id' => $otherBooking->schedule->healthFacility->id,
                        ],
                    ],
                ],
            ]);
    }

    /** @test */
    public function authenticated_user_only_get_the_details_of_their_booking()
    {
        $booking = factory(Booking::class)->create();
        $otherBooking = factory(Booking::class)->create();

        $this->signInAsPatient($booking->medicalForm->user);

        // auth user booking
        $this->getJson(route('ambulatory.inbox.show', $booking->id))
            ->assertOk()
            ->assertJson([
                'id' => $booking->id,
                'medical_form' => [
                    'id' => $booking->medicalForm->id,
                ],
                'doctor' => [
                    'id' => $booking->schedule->doctor->id,
                ],
                'health_facility' => [
                    'id' => $booking->schedule->healthFacility->id,
                ],
            ]);

        // other booking
        $this->getJson(route('ambulatory.inbox.show', $otherBooking->id))->assertStatus(404);
    }
}
