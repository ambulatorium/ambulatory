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

        $this->getJson(route('ambulatory.schedules.index'))->assertStatus(401);
        $this->getJson(route('ambulatory.schedules.show', $schedule->id))->assertStatus(401);
        $this->postJson(route('ambulatory.schedules.store', 'new'), $schedule->toArray())->assertStatus(401);
    }

    /** @test */
    public function unauthorized_users_cannot_create_a_new_schedule()
    {
        $this->signInAsAdmin();
        $this->postJson(route('ambulatory.schedules.store', 'new'), [])->assertStatus(403);

        $this->signInAsPatient();
        $this->postJson(route('ambulatory.schedules.store', 'new'), [])->assertStatus(403);
    }

    /** @test */
    public function unverified_user_as_a_doctor_cannot_create_a_new_schedule()
    {
        $user = factory(User::class)->create(['type' => User::DOCTOR]);

        $this
            ->actingAs($user, 'ambulatory')
            ->postJson(route('ambulatory.schedules.store', 'new'), [])
            ->assertStatus(403);
    }

    /** @test */
    public function a_doctor_can_create_a_new_schedule()
    {
        $this->signInAsDoctor();

        tap(factory(HealthFacility::class)->create(), function ($location) {
            $attrributes = factory(Schedule::class)->raw(['location' => $location->id]);

            $this->postJson(route('ambulatory.schedules.store', 'new'), $attrributes)->assertOk();

            $this->assertDatabaseHas('ambulatory_schedules', ['health_facility_id' => $attrributes['location']]);
        });
    }

    /** @test */
    public function included_a_health_facility_should_be_exists()
    {
        $this->signInAsDoctor();

        $attrributes = factory(Schedule::class)->raw(['location' => 'not-a-location']);

        $this->postJson(route('ambulatory.schedules.store', 'new'), $attrributes)
            ->assertStatus(422)
            ->assertJson([
                'errors' => [
                    'location' => ['The selected location is invalid.'],
                ],
            ]);

        $this->assertDatabaseMissing('ambulatory_schedules', $attrributes);
    }

    /** @test */
    public function a_doctor_and_health_facility_should_be_unique()
    {
        $user = $this->signInAsDoctor();

        $attrributes = factory(Schedule::class)->create(['doctor_id' => $user->doctorProfile->id]);

        $this->postJson(route('ambulatory.schedules.store', 'new'), [
            'location' => $attrributes->health_facility_id,
        ])
        ->assertStatus(422)
        ->assertJson([
            'errors' => [
                'location' => ['The location has already been taken.'],
            ],
        ]);
    }

    /** @test */
    public function a_doctor_cannot_view_the_schedule_of_others()
    {
        $this->signInAsDoctor();

        $schedule = factory(Schedule::class)->create();

        $this->getJson(route('ambulatory.schedules.show', $schedule->id))->assertStatus(404);
    }

    /** @test */
    public function a_doctor_can_view_their_schedule()
    {
        $user = $this->signInAsDoctor();

        $schedule = factory(Schedule::class)->create(['doctor_id' => $user->doctorProfile->id]);

        $this->getJson(route('ambulatory.schedules.show', $schedule->id))
            ->assertOk()
            ->assertJson(['entry' => $schedule->toArray()]);
    }

    /** @test */
    public function a_doctor_cannot_update_the_schedule_of_others()
    {
        $this->signInAsDoctor();

        $schedule = factory(Schedule::class)->create();

        $this->postJson(route('ambulatory.schedules.store', $schedule->id),
            factory(Schedule::class)->raw([
                'location' => $schedule->health_facility_id
            ])
        )->assertStatus(404);
    }

    /** @test */
    public function a_doctor_can_update_their_schedule()
    {
        $user = $this->signInAsDoctor();

        $schedule = factory(Schedule::class)->create(['doctor_id' => $user->doctorProfile->id]);

        $this->postJson(route('ambulatory.schedules.store', $schedule->id),
            $attributes = factory(Schedule::class)->raw([
                'location' => $schedule->health_facility_id,
                'start_date_time' => now()->addDays(2)->toDateTimeString(),
            ])
        )->assertOk();

        $this->assertNotSame($schedule->start_date_time, $attributes['start_date_time']);

        $this->assertDatabaseHas('ambulatory_schedules', ['start_date_time' => $attributes['start_date_time']]);
    }
}
