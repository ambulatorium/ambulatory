<?php

namespace Reliqui\Ambulatory\Tests\Feature;

use Reliqui\Ambulatory\User;
use Reliqui\Ambulatory\Schedule;
use Reliqui\Ambulatory\HealthFacility;
use Reliqui\Ambulatory\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DoctorScheduleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_cannot_manage_doctor_schedule()
    {
        $schedule = factory(Schedule::class)->create();

        $this->getJson(route('ambulatory.schedules'))->assertStatus(401);
        $this->postJson(route('ambulatory.schedules.store'), [])->assertStatus(401);
        $this->getJson(route('ambulatory.schedules.show', $schedule->id))->assertStatus(401);
        $this->patchJson(route('ambulatory.schedules.update', $schedule->id), [])->assertStatus(401);
    }

    /** @test */
    public function unauthorized_users_cannot_create_a_new_schedule()
    {
        $this->signInAsAdmin();
        $this->postJson(route('ambulatory.schedules.store'), [])->assertStatus(403);

        $this->signInAsPatient();
        $this->postJson(route('ambulatory.schedules.store'), [])->assertStatus(403);
    }

    /** @test */
    public function unverified_doctor_cannot_create_a_new_schedule()
    {
        $user = factory(User::class)->create(['type' => User::DOCTOR]);

        $this
            ->actingAs($user, 'ambulatory')
            ->postJson(route('ambulatory.schedules.store'), [])
            ->assertStatus(403);
    }

    /** @test */
    public function verified_doctor_can_create_a_new_schedule()
    {
        $this->signInAsDoctor();

        tap(factory(HealthFacility::class)->create(), function ($location) {
            $attrributes = factory(Schedule::class)->raw(['location' => $location->id]);

            $this->postJson(route('ambulatory.schedules.store'), $attrributes)->assertOk();

            $this->assertDatabaseHas('reliqui_schedules', ['health_facility_id' => $attrributes['location']]);
        });
    }

    /** @test */
    public function included_a_health_facility_should_be_exists()
    {
        $this->signInAsDoctor();

        $attrributes = factory(Schedule::class)->raw(['location' => 'not-a-location']);

        $this->postJson(route('ambulatory.schedules.store'), $attrributes)
            ->assertStatus(422)
            ->assertExactJson([
                'errors' => [
                    'location' => ['The selected location is invalid.'],
                ],
                'message' => 'The given data was invalid.',
            ]);

        $this->assertDatabaseMissing('reliqui_schedules', $attrributes);
    }

    /** @test */
    public function end_date_should_be_after_from_the_start_date()
    {
        $this->signInAsDoctor();

        $location = factory(HealthFacility::class)->create();

        $attributes = factory(Schedule::class)->raw([
            'location' => $location->id,
            'start_date' => today()->addDays(2)->toDateTimeString(),
            'end_date' => today()->toDateTimeString(),
        ]);

        $this->postJson(route('ambulatory.schedules.store'), array_except($attributes, ['health_facility_id']))
            ->assertStatus(422)
            ->assertJsonValidationErrors('end_date')
            ->assertExactJson([
                'errors' => [
                    'end_date' => ['The end date must be a date after start date.'],
                ],
                'message' => 'The given data was invalid.',
            ]);
    }

    /** @test */
    public function a_doctor_can_get_their_details_of_schedule()
    {
        $user = $this->signInAsDoctor();

        $schedule = factory(Schedule::class)->create([
            'doctor_id' => $user->doctorProfile->id,
        ]);

        $this->getJson(route('ambulatory.schedules.show', $schedule->id))
            ->assertOk()
            ->assertExactJson([
                'entry' => $schedule->load('healthFacility')->toArray(),
            ]);
    }

    /** @test */
    public function a_doctor_can_not_get_the_details_schedule_of_others()
    {
        $this->signInAsDoctor();

        $schedule = factory(Schedule::class)->create();

        $this->getJson(route('ambulatory.schedules.show', $schedule->id))->assertStatus(403);
    }

    /** @test */
    public function a_doctor_can_not_update_the_schedule_of_others()
    {
        $this->signInAsDoctor();

        $schedule = factory(Schedule::class)->create();

        $this->patch(route('ambulatory.schedules.update', $schedule->id),
            factory(Schedule::class)->raw([
                'location' => $schedule->health_facility_id,
            ])
        )->assertStatus(403);
    }

    /** @test */
    public function a_doctor_can_update_their_schedule()
    {
        $user = $this->signInAsDoctor();

        $schedule = factory(Schedule::class)->create(['doctor_id' => $user->doctorProfile->id]);

        $this->patchJson(route('ambulatory.schedules.update', $schedule->id),
            $attributes = factory(Schedule::class)->raw([
                'location' => $schedule->health_facility_id,
                'start_date' => now()->addDays(2)->toDateTimeString(),
            ])
        )->assertOk();

        $this->assertNotSame($schedule->start_date_time, $attributes['start_date']);

        $this->assertDatabaseHas('reliqui_schedules', ['start_date' => $attributes['start_date']]);
    }
}
